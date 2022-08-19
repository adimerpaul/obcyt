<template>
<q-page>
<div class="row">
  <div class="col-12 text-h6 text-center">
         GENERAR IMPRESION DE CERTIFICADOS Y CREDENCIALES MASIVOS
        
  </div>
  <div class="col-4">
  <q-btn class="full-width" color="green" label="CERTIFICADOS PARTICIPANTES" @click="participanteClick"/>
    
  </div>  
  <div class="col-4">
  <q-btn class="full-width" color="accent" label="CERTIFICADOS CLUB"  />
    
  </div>  
  <div class="col-4">
  <q-btn class="full-width" color="yellow" label="CREDENCIALES" />
    
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
    datoEliminar(dato){
      this.$q.dialog({
        title: 'Eliminar',
        message: '¿Desea eliminar el registro?',
        cancel: true,
        persistent: true,
        ok: {
          label: 'Eliminar',
          color: 'red-9',
        }
      }).onOk(()=>{
        this.loading = true
        this.$api.delete('puntos/'+dato.id).then(()=>{
          this.loading = false
          this.dato = {}
          this.datos(this.participante)
        })
      });


    },
    datoInsert(){

      if (this.dato.categoria == undefined) {
        this.$q.notify({
          color: 'red-6',
          textColor: 'white',
          icon: 'error',
          message: 'Seleccione una categoria',
          position: 'top',
          timeout: 4000
        })
        return false
      }
      if (this.dato.punto == undefined) {
        this.$q.notify({
          color: 'red-6',
          textColor: 'white',
          icon: 'error',
          message: 'Ingrese un punto',
          position: 'top',
          timeout: 4000
        })
        return false
      }
      this.loading = true
      this.dato.participante_id = this.participante.id
      this.dato.user_id = this.store.user.id
      this.$api.post('puntos',this.dato).then(res=>{
        this.loading = false
        this.dato={}
        this.datos(this.participante)
      })
    },
    certificadoClub(participante){
      this.participante=participante
      this.printCertificado(participante.club,participante)
    },
    certificadoUser1(participante){
      this.participante=participante
      this.printCertificado(participante.nombre1,participante)
    },
    certificadoUser2(participante){
      this.participante=participante
      this.printCertificado(participante.nombre2,participante)
    },

    async credencialUser1(nombre,codigo,participante,foto) {
      this.loading=true
      this.$api.get('base64/'+foto).then(res=>{
        this.loading=false
        let foto=res.data
        let doc = new jsPDF('landscape', null, 'letter');
        let logo = new Image();
        logo.src = 'frontal.png';
        // doc.addImage(logo, 'PNG', 7+69.7*0.95*0, 10+97.1*0.95*0, 69.7*0.95, 97.1*0.95);
        // doc.addImage(logo, 'PNG', 7+69.7*0.95*1, 10+97.1*0.95*0, 69.7*0.95, 97.1*0.95);
        // doc.addImage(logo, 'PNG', 7+69.7*0.95*2, 10+97.1*0.95*0, 69.7*0.95, 97.1*0.95);
        doc.addImage(logo, 'PNG', 7+69.7*0.95*3, 10+97.1*0.95*0, 69.7*0.95, 97.1*0.95);
        // doc.addImage(foto, 'PNG', 29+23*0+69.7*0.95*0-23*0, 32+23*0, 23, 23);
        // doc.addImage(foto, 'PNG', 29+23*1+69.7*0.95*1-23*1, 32+23*0, 23, 23);
        // doc.addImage(foto, 'PNG', 29+23*2+69.7*0.95*2-23*2, 32+23*0, 23, 23);
        doc.addImage(foto, 'PNG', 29+23*3+69.7*0.95*3-23*3, 32+23*0, 23, 23);
        logo.src = 'trasera.png';
        // doc.addImage(logo, 'PNG', 7+69.7*0.95*0, 10+97.1*0.95*1, 69.7*0.95, 97.1*0.95);
        // doc.addImage(logo, 'PNG', 7+69.7*0.95*1, 10+97.1*0.95*1, 69.7*0.95, 97.1*0.95);
        // doc.addImage(logo, 'PNG', 7+69.7*0.95*2, 10+97.1*0.95*1, 69.7*0.95, 97.1*0.95);
        doc.addImage(logo, 'PNG', 7+69.7*0.95*3, 10+97.1*0.95*1, 69.7*0.95, 97.1*0.95);

        doc.setFont('courier','bold')
        doc.setFontSize(11)

        // doc.text(nombre == null ? '' : nombre, 41+69.7*0.95*0, 70, {maxWidth: 50, align: "center"});
        // doc.text(codigo == null ? '' : codigo, 41+69.7*0.95*0, 83, 'center')
        // doc.text(nombre == null ? '' : nombre, 41+69.7*0.95*1, 70, {maxWidth: 50, align: "center"});
        // doc.text(codigo == null ? '' : codigo, 41+69.7*0.95*1, 83, 'center')
        // doc.text(nombre == null ? '' : nombre, 41+69.7*0.95*2, 70, {maxWidth: 50, align: "center"});
        // doc.text(codigo == null ? '' : codigo, 41+69.7*0.95*2, 83, 'center')
        doc.text(nombre == null ? '' : nombre, 41+69.7*0.95*3, 70, {maxWidth: 50, align: "center"});
        doc.text(codigo == null ? '' : codigo, 41+69.7*0.95*3, 83, 'center')

        doc.setFontSize(10)

        // doc.text(codigo == null ? '' : codigo, 41+69.7*0.95*0, 150, 'center')
        // doc.text(nombre == null ? '' : nombre, 41+69.7*0.95*0, 160, {maxWidth: 50, align: "center"});
        // doc.text(codigo == null ? '' : codigo, 41+69.7*0.95*1, 150, 'center')
        // doc.text(nombre == null ? '' : nombre, 41+69.7*0.95*1, 160, {maxWidth: 50, align: "center"});
        // doc.text(codigo == null ? '' : codigo, 41+69.7*0.95*2, 150, 'center')
        // doc.text(nombre == null ? '' : nombre, 41+69.7*0.95*2, 160, {maxWidth: 50, align: "center"});
        doc.text(codigo == null ? '' : codigo, 41+69.7*0.95*3, 150, 'center')
        doc.text(nombre == null ? '' : nombre, 41+69.7*0.95*3, 160, {maxWidth: 50, align: "center"});

        doc.save('Credencial '+nombre+'.pdf')
        // window.open(doc.output('bloburl'), '_blank')
      })
    },
    credencialUser2(participante){
      this.participante=participante
    },
    participanteClick(){
      this.loading=true
      this.$api.get(`participante`).then(res => {
        this.loading=false
        this.participantes = res.data
            this.printCertificado()
      })
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
