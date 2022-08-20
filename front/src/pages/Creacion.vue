<template>
<q-page>
<div class="row">
  <div class="col-12 text-h6 text-center">
         GENERAR IMPRESION DE CERTIFICADOS Y CREDENCIALES MASIVOS

  </div>
  <div class="col-4 q-pa-xs">
  <q-btn class="full-width" :loading="loading" icon="picture_as_pdf" color="green" label="CERTIFICADOS PARTICIPANTES" @click="participanteClick"/>

  </div>
  <div class="col-4 q-pa-xs">
  <q-btn class="full-width" :loading="loading" icon="picture_as_pdf" color="accent" label="CERTIFICADOS CLUB"  @click="clubClick"/>

  </div>
  <div class="col-4 q-pa-xs">
  <q-btn class="full-width" :loading="loading" icon="picture_as_pdf" color="yellow-9" label="CREDENCIALES" @click="credencialClick"/>

  </div>
</div>




  <div id="qr_code" style="display: none"></div>
</q-page>
</template>

<script>
import {date} from "quasar";
import moment from "moment";
import {jsPDF} from "jspdf";
import $ from "jquery";
import {useCounterStore} from "stores/example-store";
var QRCode = require('qrcode')
export default {
  name: `Competidor`,
  data () {
    return {
      dato:{},
      store:useCounterStore(),
      loading:false,
      participanteDatosDialog:false,
      participanteFilter:'',
      puntos:[],
      participanteDialog:false,
      participanteUpdateDialog:false,
      participantes: [],
      datoOpcion:[],
        foto:'',
        foto2:'',
      participante:{
        fechaNac1:date.formatDate(new Date(), 'YYYY-MM-DD'),
        fechaNac2:date.formatDate(new Date(), 'YYYY-MM-DD'),
        controlRCPrimaria: false,
        seguidordelineaAmateur: false,
        minisumoRcAmateur: false,
        minisumoAutonomoAmateur: false,
        carreradeInsectosAmateur: false,
        peleadeRobotsAmateur: false,
        minisumoAutonomoProfesional: false,
        minisumoRcProfesional: false,
        microsumoProfesional: false,
        seguidordelineaProfesional: false,
        carreradeInsectosProfesional: false,
        creatividadeInnovacionTecnologicaProyectos: false,
        guerradeRobotsProfesional1Lb: false,
        autoaControlRCBluetooth: false,
        robotSoccer: false,
      },
    }
  },
  created () {
    this.participantesGet()
  },
  methods:{
    async credencialUser1(nombre,codigo,foto) {
      this.loading=true
      this.$api.get('base64/'+foto).then(res=>{
        this.loading=false
        let foto=res.data
        let doc = new jsPDF('landscape', null, 'letter');
        let logo = new Image();
        logo.src = 'frontal.png';
        doc.addImage(logo, 'PNG', 7+69.7*0.95*3, 10+97.1*0.95*0, 69.7*0.95, 97.1*0.95);
        doc.addImage(foto, 'PNG', 29+23*3+69.7*0.95*3-23*3, 32+23*0, 23, 23);
        logo.src = 'trasera.png';
        doc.addImage(logo, 'PNG', 7+69.7*0.95*3, 10+97.1*0.95*1, 69.7*0.95, 97.1*0.95);

        doc.setFont('courier','bold')
        doc.setFontSize(11)

        doc.text(nombre == null ? '' : nombre, 41+69.7*0.95*3, 70, {maxWidth: 50, align: "center"});
        doc.text(codigo == null ? '' : codigo, 41+69.7*0.95*3, 83, 'center')

        doc.setFontSize(10)

        doc.text(codigo == null ? '' : codigo, 41+69.7*0.95*3, 150, 'center')
        doc.text(nombre == null ? '' : nombre, 41+69.7*0.95*3, 160, {maxWidth: 50, align: "center"});

        doc.save('Credencial '+nombre+date.formatDate(new Date(),'HHmmss')+'.pdf')
      })
    },

    async credencialUser000() {
        let doc = new jsPDF('landscape', null, 'letter');
        let logo = new Image();
        let logo2 = new Image();
        logo.src = 'frontal.png';
        logo2.src = 'trasera.png';
        let foto=''
        let foto2=''
               for (const participante of this.participantes){

        if(participante.nombre1!=null){
      this.$api.get('base64/'+participante.foto1).then(res=>{
         this.foto=res.data


        // window.open(doc.output('bloburl'), '_blank')
      })
        foto=this.foto
        doc.addImage(logo, 'PNG', 7+69.7*0.95*3, 10+97.1*0.95*0, 69.7*0.95, 97.1*0.95);
        doc.addImage(foto, 'PNG', 29+23*3+69.7*0.95*3-23*3, 32+23*0, 23, 23);
        doc.addImage(logo2, 'PNG', 7+69.7*0.95*3, 10+97.1*0.95*1, 69.7*0.95, 97.1*0.95);

        doc.setFont('courier','bold')
        doc.setFontSize(11)

        doc.text(participante.nombre1, 41+69.7*0.95*3, 70, {maxWidth: 50, align: "center"});
        doc.text(participante.fechaNac1 == null ? '' : participante.fechaNac1, 41+69.7*0.95*3, 83, 'center')

        doc.setFontSize(10)

        doc.text(participante.fechaNac1 == null ? '' : participante.fechaNac1, 41+69.7*0.95*3, 150, 'center')
        doc.text(participante.fechaNac1, 41+69.7*0.95*3, 160, {maxWidth: 50, align: "center"});
        }
      if(participante.nombre2!=null){
          doc.addPage();
        this.$api.get('base64/'+participante.foto2).then(res=>{

        this.foto2=res.data
      })
        foto2=this.foto2
        doc.addImage(logo, 'PNG', 7+69.7*0.95*3, 10+97.1*0.95*0, 69.7*0.95, 97.1*0.95);
        doc.addImage(foto2, 'PNG', 29+23*3+69.7*0.95*3-23*3, 32+23*0, 23, 23);
        doc.addImage(logo2, 'PNG', 7+69.7*0.95*3, 10+97.1*0.95*1, 69.7*0.95, 97.1*0.95);

        doc.setFont('courier','bold')
        doc.setFontSize(11)

        doc.text(participante.nombre2, 41+69.7*0.95*3, 70, {maxWidth: 50, align: "center"});
        doc.text(participante.fechaNac2 == null ? '' : participante.fechaNac2, 41+69.7*0.95*3, 83, 'center')

        doc.setFontSize(10)

        doc.text(participante.fechaNac2 == null ? '' : participante.fechaNac2, 41+69.7*0.95*3, 150, 'center')
        doc.text(participante.fechaNac2, 41+69.7*0.95*3, 160, {maxWidth: 50, align: "center"});
      }
               doc.addPage();
               }
        doc.save('Credencial.pdf')

    },


    participanteClick(){
      this.loading=true
      this.$api.get(`participante`).then(res => {
        this.loading=false
        this.participantes = res.data
            this.printCertificado()
      })
    },

        clubClick(){
      this.loading=true
      this.$api.get(`participante`).then(res => {
        this.loading=false
        this.participantes = res.data
            this.printCertificadoclub()
      })
    },


    credencialClick(){
      this.loading=true
      this.$api.get(`credenciales`).then(res => {
        this.loading=false
        this.participantes = res.data
        console.log(this.participantes)
        let doc = new jsPDF('landscape', null, 'letter');
        let logo = new Image();
        logo.src = 'frontal.png';
        let trasera = new Image();
        trasera.src = 'trasera.png';
        let i=1
        this.participantes.forEach(p=>{
          let foto=p.foto
          let nombre=p.nombre
          let codigo=p.club
          if (i==1){
            doc.addImage(logo, 'PNG', 7+69.7*0.95*0, 10+97.1*0.95*0, 69.7*0.95, 97.1*0.95);
            doc.addImage(trasera, 'PNG', 7+69.7*0.95*0, 10+97.1*0.95*1, 69.7*0.95, 97.1*0.95);
            doc.addImage(foto, 'PNG', 29+23*0+69.7*0.95*0-23*0, 32+23*0, 23, 23);
            doc.setFont('courier','bold')
            doc.setFontSize(11)
            doc.text(nombre == null ? '' : nombre, 41+69.7*0.95*0, 70, {maxWidth: 50, align: "center"});
            doc.text(codigo == null ? '' : codigo, 41+69.7*0.95*0, 83, 'center')
            doc.setFontSize(10)
            doc.text(codigo == null ? '' : codigo, 41+69.7*0.95*0, 150, 'center')
            doc.text(nombre == null ? '' : nombre, 41+69.7*0.95*0, 160, {maxWidth: 50, align: "center"});
            i++;
          }
          else if (i==2){
            doc.addImage(logo, 'PNG', 7+69.7*0.95*1, 10+97.1*0.95*0, 69.7*0.95, 97.1*0.95);
            doc.addImage(trasera, 'PNG', 7+69.7*0.95*1, 10+97.1*0.95*1, 69.7*0.95, 97.1*0.95);
            doc.addImage(foto, 'PNG', 29+23*1+69.7*0.95*1-23*1, 32+23*0, 23, 23);
            doc.setFont('courier','bold')
            doc.setFontSize(11)
            doc.text(nombre == null ? '' : nombre, 41+69.7*0.95*1, 70, {maxWidth: 50, align: "center"});
            doc.text(codigo == null ? '' : codigo, 41+69.7*0.95*1, 83, 'center')
            doc.setFontSize(10)
            doc.text(codigo == null ? '' : codigo, 41+69.7*0.95*1, 150, 'center')
            doc.text(nombre == null ? '' : nombre, 41+69.7*0.95*1, 160, {maxWidth: 50, align: "center"});
            i++;
          }
          else if (i==3){
            doc.addImage(logo, 'PNG', 7+69.7*0.95*2, 10+97.1*0.95*0, 69.7*0.95, 97.1*0.95);
            doc.addImage(trasera, 'PNG', 7+69.7*0.95*2, 10+97.1*0.95*1, 69.7*0.95, 97.1*0.95);
            doc.addImage(foto, 'PNG', 29+23*2+69.7*0.95*2-23*2, 32+23*0, 23, 23);
            doc.setFont('courier','bold')
            doc.setFontSize(11)
            doc.text(nombre == null ? '' : nombre, 41+69.7*0.95*2, 70, {maxWidth: 50, align: "center"});
            doc.text(codigo == null ? '' : codigo, 41+69.7*0.95*2, 83, 'center')
            doc.setFontSize(10)
            doc.text(codigo == null ? '' : codigo, 41+69.7*0.95*2, 150, 'center')
            doc.text(nombre == null ? '' : nombre, 41+69.7*0.95*2, 160, {maxWidth: 50, align: "center"});
            i++
          }else if (i==4){
            doc.addImage(logo, 'PNG', 7+69.7*0.95*3, 10+97.1*0.95*0, 69.7*0.95, 97.1*0.95);
            doc.addImage(trasera, 'PNG', 7+69.7*0.95*3, 10+97.1*0.95*1, 69.7*0.95, 97.1*0.95);
            doc.addImage(foto, 'PNG', 29+23*3+69.7*0.95*3-23*3, 32+23*0, 23, 23);
            doc.setFont('courier','bold')
            doc.setFontSize(11)
            doc.text(nombre == null ? '' : nombre, 41+69.7*0.95*3, 70, {maxWidth: 50, align: "center"});
            doc.text(codigo == null ? '' : codigo, 41+69.7*0.95*3, 83, 'center')
            doc.setFontSize(10)
            doc.text(codigo == null ? '' : codigo, 41+69.7*0.95*3, 150, 'center')
            doc.text(nombre == null ? '' : nombre, 41+69.7*0.95*3, 160, {maxWidth: 50, align: "center"});
            i=1
            doc.addPage();
          }
        })
        doc.save('Credencial '+date.formatDate(new Date(),'HHmmss')+'.pdf')

            // this.credencialUser()
        // this.participantes.forEach(r=>{
        //     this.credencialUser1(r.nombre1,r.fechaNac1,r.foto1)
        //     this.credencialUser1(r.nombre2,r.fechaNac2,r.foto2)
        // })
      })
      // this.loading=true
      // this.$api.get(`participante`).then(res => {
      //   this.loading=false
      //   this.participantes = res.data
      //   this.participantes.forEach(r=>{
      //       this.credencialUser1(r.nombre1,r.fechaNac1,r.foto1)
      //       this.credencialUser1(r.nombre2,r.fechaNac2,r.foto2)
      //   })
      // })
    },

    async printCertificado() {
      let doc = new jsPDF('landscape', null, 'letter');
      let logo = new Image();
      logo.src = 'certificado.jpg';

       for (const participante of this.participantes){
      let categorias = ''

      categorias += participante.controlRCPrimaria == 1 ? " controlRCPrimaria," : ''
      categorias += participante.seguidordelineaAmateur == 1 ? " seguidordelineaAmateur," : ''
      categorias += participante.minisumoRcAmateur == 1 ? " minisumoRcAmateur," : ''
      categorias += participante.minisumoAutonomoAmateur == 1 ? " minisumoAutonomoAmateur," : ''
      categorias += participante.carreradeInsectosAmateur == 1 ? " carreradeInsectosAmateur," : ''
      categorias += participante.peleadeRobotsAmateur == 1 ? " peleadeRobotsAmateur," : ''
      categorias += participante.minisumoAutonomoProfesional == 1 ? " minisumoAutonomoProfesional," : ''
      categorias += participante.minisumoRcProfesional == 1 ? " minisumoRcProfesional," : ''
      categorias += participante.microsumoProfesional == 1 ? " microsumoProfesional," : ''
      categorias += participante.seguidordelineaProfesional == 1 ? " seguidordelineaProfesional," : ''
      categorias += participante.carreradeInsectosProfesional == 1 ? " carreradeInsectosProfesional," : ''
      categorias += participante.creatividadeInnovacionTecnologicaProyectos == 1 ? " creatividadeInnovacionTecnologicaProyectos," : ''
      categorias += participante.guerradeRobotsProfesional1Lb == 1 ? " guerradeRobotsProfesional1Lb," : ''
      categorias += participante.autoaControlRCBluetooth == 1 ? " autoaControlRCBluetooth," : ''
      categorias += participante.robotSoccer == 1 ? " robotSoccer," : ''

      if(participante.nombre1!=null){
      doc.addImage(logo, 'JPEG', 0, 0, 280, 210);
      doc.setFont('times')
      doc.setFontSize(13, 'normal')
      doc.text('Se otorga el presente certificado A:', 30, 70)
      doc.setFontSize(20, 'bold')
      doc.text(participante.nombre1, 140, 80, 'center')
      doc.setFontSize(13, 'normal')
      doc.text('Por la participación en Olimpiada Boliviana de Ciencia y Tecnología BALLIVIANITOBOT en calidad de:', 30, 90)
      doc.setFontSize(20, 'bold')
      doc.text(participante.categoria == null ? '' : participante.categoria, 140, 100, 'center')
      doc.setFontSize(13, 'normal')
      doc.text("Con las participaciones en la(s) categoría(s):" + categorias, 30, 110, {
        maxWidth: 220,
        align: "justify"
      }); // to justify

      let nom=participante.nombre1
      let opts = {
        errorCorrectionLevel: 'M',
          type: 'png',
          quality: 0.95,
          width: 100,
          margin: 1,
          color: {
          dark: '#000000',
            light: '#FFF',
        }
      }
      let qrImage = await QRCode.toDataURL("Nombre:"+nom+"\nCategoria: "+participante.categoria, opts)


        // let base64Image = $('#qr_code img').attr('src');
        doc.addImage(qrImage, 'png', 235, 135, 25, 25);
        // window.open(doc.output('bloburl'), '_blank')
      }

      if(participante.nombre2!==null){
          doc.addPage();
                doc.addImage(logo, 'JPEG', 0, 0, 280, 210);
      doc.setFont('times')
      doc.setFontSize(13, 'normal')
      doc.text('Se otorga el presente certificado A:', 30, 70)
      doc.setFontSize(20, 'bold')
      doc.text(participante.nombre2, 140, 80, 'center')
      doc.setFontSize(13, 'normal')
      doc.text('Por la participación en Olimpiada Boliviana de Ciencia y Tecnología BALLIVIANITOBOT en calidad de:', 30, 90)
      doc.setFontSize(20, 'bold')
      doc.text(participante.categoria == null ? '' : participante.categoria, 140, 100, 'center')
      doc.setFontSize(13, 'normal')
      doc.text("Con las participaciones en la(s) categoría(s):" + categorias, 30, 110, {
        maxWidth: 220,
        align: "justify"
      }); // to justify

      let nom=participante.nombre2
      let opts = {
        errorCorrectionLevel: 'M',
          type: 'png',
          quality: 0.95,
          width: 100,
          margin: 1,
          color: {
          dark: '#000000',
            light: '#FFF',
        }
      }
      let qrImage = await QRCode.toDataURL("Nombre:"+nom+"\nCategoria: "+participante.categoria, opts)

        // let base64Image = $('#qr_code img').attr('src');
        doc.addImage(qrImage, 'png', 235, 135, 25, 25);
        // window.open(doc.output('bloburl'), '_blank')
      }
       doc.addPage();
      }
        doc.save('Certificado.pdf')

    },

    async printCertificadoclub() {
      let doc = new jsPDF('landscape', null, 'letter');
      let logo = new Image();
      logo.src = 'certificado.jpg';

       for (const participante of this.participantes){
      let categorias = ''

      categorias += participante.controlRCPrimaria == 1 ? " controlRCPrimaria," : ''
      categorias += participante.seguidordelineaAmateur == 1 ? " seguidordelineaAmateur," : ''
      categorias += participante.minisumoRcAmateur == 1 ? " minisumoRcAmateur," : ''
      categorias += participante.minisumoAutonomoAmateur == 1 ? " minisumoAutonomoAmateur," : ''
      categorias += participante.carreradeInsectosAmateur == 1 ? " carreradeInsectosAmateur," : ''
      categorias += participante.peleadeRobotsAmateur == 1 ? " peleadeRobotsAmateur," : ''
      categorias += participante.minisumoAutonomoProfesional == 1 ? " minisumoAutonomoProfesional," : ''
      categorias += participante.minisumoRcProfesional == 1 ? " minisumoRcProfesional," : ''
      categorias += participante.microsumoProfesional == 1 ? " microsumoProfesional," : ''
      categorias += participante.seguidordelineaProfesional == 1 ? " seguidordelineaProfesional," : ''
      categorias += participante.carreradeInsectosProfesional == 1 ? " carreradeInsectosProfesional," : ''
      categorias += participante.creatividadeInnovacionTecnologicaProyectos == 1 ? " creatividadeInnovacionTecnologicaProyectos," : ''
      categorias += participante.guerradeRobotsProfesional1Lb == 1 ? " guerradeRobotsProfesional1Lb," : ''
      categorias += participante.autoaControlRCBluetooth == 1 ? " autoaControlRCBluetooth," : ''
      categorias += participante.robotSoccer == 1 ? " robotSoccer," : ''

      if(participante.club!=null){
      doc.addImage(logo, 'JPEG', 0, 0, 280, 210);
      doc.setFont('times')
      doc.setFontSize(13, 'normal')
      doc.text('Se otorga el presente certificado A:', 30, 70)
      doc.setFontSize(20, 'bold')
      doc.text(participante.club, 140, 80, 'center')
      doc.setFontSize(13, 'normal')
      doc.text('Por la participación en Olimpiada Boliviana de Ciencia y Tecnología BALLIVIANITOBOT en calidad de:', 30, 90)
      doc.setFontSize(20, 'bold')
      doc.text(participante.categoria == null ? '' : participante.categoria, 140, 100, 'center')
      doc.setFontSize(13, 'normal')
      doc.text("Con las participaciones en la(s) categoría(s):" + categorias, 30, 110, {
        maxWidth: 220,
        align: "justify"
      }); // to justify

      let nom=participante.club
      let opts = {
        errorCorrectionLevel: 'M',
          type: 'png',
          quality: 0.95,
          width: 100,
          margin: 1,
          color: {
          dark: '#000000',
            light: '#FFF',
        }
      }
      let qrImage = await QRCode.toDataURL("Nombre:"+nom+"\nCategoria: "+participante.categoria, opts)


        // let base64Image = $('#qr_code img').attr('src');
        doc.addImage(qrImage, 'png', 235, 135, 25, 25);
        // window.open(doc.output('bloburl'), '_blank')
      }


       doc.addPage();
      }
        doc.save('Certificado.pdf')

    },
    participantesGet(){
      this.loading=true
      this.$api.get(`participante`).then(res => {
        this.loading=false
        this.participantes = res.data
      })
    }
  }
}
</script>

<style scoped>

</style>
