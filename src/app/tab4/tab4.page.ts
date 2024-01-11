import { Component, OnInit } from '@angular/core';
import axios from 'axios';

@Component({
  selector: 'app-tab4',
  templateUrl: './tab4.page.html',
  styleUrls: ['./tab4.page.scss'],
})
export class Tab4Page  {
 
 
  // Variabel GetData for array
  public allData:any = [];
  public inputCari: string = '';
  public cari: any = [];
 
  constructor() {
    // Form Load GetData
    this.GetData();
  }
  handleRefresh(event:any) {
    setTimeout(() => {
      // Any calls to load data go here
      event.target.complete();
      this.GetData()
    }, 2000);
  };
 
  handleInput(event:any) {
    this.inputCari = event.target.value.toLowerCase();
    this.filterItems();
  }

  // Function GetData from API ---------------------------------------------------------------------------
  async GetData(){
    const res:any = await axios.get('https://praktikum-cpanel-unbin.com/api_uas/get_data_mahasiswa.php');
  
    this.cari = res.data.result;
    this.allData = this.cari;

    console.log(res.data);
    this.allData = res.data.result;
  }

  filterItems() {
    if (this.inputCari !==''){
      this.allData = this.cari.filter((item : any) =>{
        return item.nama_lengkap.toLowerCase().includes(this.inputCari);
      });
    } else {
      this.allData = this.cari;
    }
  }
  // Function getData ---------------------------------------------------------------------------
  
}