import { Component, Input, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { AlertController, LoadingController, ModalController } from '@ionic/angular';
import { Observable } from 'rxjs';
import { take } from 'rxjs/operators';
import { Producto } from '../productos/producto.model';
import { AuthService } from '../services/auth.service';
import { ProductosService } from '../services/productos.service';

@Component({
  selector: 'app-agregar-producto',
  templateUrl: './agregar-producto.page.html',
  styleUrls: ['./agregar-producto.page.scss'],
})
export class AgregarProductoPage implements OnInit {
  @Input() producto:Producto;
  isEditMode=false;
  form:FormGroup;
  user:any;
  admin:any;
  constructor(private productoService:ProductosService, 
    private loadingController:LoadingController, 
    private modalController: ModalController,
    private authService:AuthService,
    private alertController: AlertController) { }

  ngOnInit() {
    this.initAddProductoForm();

    if(this.producto){
      this.isEditMode=true;
      this.setFormValues();
    }
    this.ionViewDidLoad();
  }

  initAddProductoForm(){
    this.form=new FormGroup({
      nombre: new FormControl(null,[Validators.required]),
      descripcion: new FormControl(null),
      precio: new FormControl(null,[Validators.required]),
    });
  }

  setFormValues(){
    this.form.setValue({
      nombre:this.producto.nombre,
      descripcion:this.producto.descripcion,
      precio:this.producto.precio
    });

    this.form.updateValueAndValidity();
  }

  closeModal(data=null){
    this.modalController.dismiss(data);
  }

  async submitProductos(){
    const loading= await this.loadingController.create({message:'Cargando...'});
    loading.present();

    let response:Observable<Producto>;

    if(this.isEditMode){
      this.productoService.updateProducto(this.producto.id,this.form.value)
      .then((data)=>{
        response = data; response.pipe(take(1))
          .subscribe((producto)=>{
            this.form.reset();
            loading.dismiss();
    
          if(this.isEditMode){
            this.closeModal(producto);
          }
        });
      });
    } else{
      this.productoService.addProducto(this.form.value)
      .then((data)=>{
        response = data;
        response.pipe(take(1))
          .subscribe((producto)=>{
            this.form.reset();
            loading.dismiss();
    
          if(this.isEditMode){
            this.closeModal(producto);
          }
        });
      });
    }
    
   

  }

  async ionViewCanEnter() {
    let isAuthenticated = this.authService.checkIsAuthenticated();

    return isAuthenticated;
  }

  ionViewDidLoad() {
    this.getUser();
  }

  private async getUser() {
    try {
      let response:any=await this.authService.getUser();
      console.log(response)
      this.user=response;
      this.admin=this.user.admin
    } catch (error) {
      console.log(error);
      let alert = this.alertController.create({
        header: 'Error',
        message: 'No se ha podido obtener los datos del usuario',
        buttons: ['ok']
      });
      (await alert).present();
    }
  }

}
