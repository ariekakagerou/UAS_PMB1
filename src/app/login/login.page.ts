import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ToastController } from '@ionic/angular';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {
  npm:any=""
  email:any=""
  constructor(private router:Router,public toastCtrl:ToastController,) { }

  ngOnInit() {
  }

  async login(){
    if(this.npm == "" || this.email == ""){
      const toast = await this.toastCtrl.create({
        message:'Input terlebih dahulu NPM dan Email!',
        duration: 2000,
        color: 'danger'  
      });
      toast.present();
    } else {
      this.router.navigate(['/tabs/tab1'])
    }
  }
}
