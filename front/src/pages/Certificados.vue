<template>
<q-page>
<div class="row">
  <div class="col-12">
    <q-table dense :rows="participantes" :columns="participanteColumns" :rows-per-page-options="[0]" :filter="participanteFilter">
      <template v-slot:top-right>
        <q-btn color="green" :loading="loading" @click="participanteClick" icon="add_circle_outline" :label="$q.screen.lt.md?'':'Registrar'" />
        <q-btn color="blue" :loading="loading" @click="participantesGet" icon="refresh" :label="$q.screen.lt.md?'':'Actualizar'" />
        <q-input dense outlined v-model="participanteFilter" placeholder="Buscar">
          <template v-slot:prepend>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>
      <template v-slot:body-cell-Opciones="props">
        <q-td :props="props" >
          <q-btn color="info"  dense label="PDF" icon="download" @click="printCertificado(props.row)"/>
        </q-td>
      </template>
      <template v-slot:body-cell-Participantes="props">
        <q-td :props="props" auto-width>
          <ul style="list-style: none">
            <li>1.- {{props.row.nombre1}} </li>
            <li v-if="props.row.nombre2!=null">2.- {{props.row.nombre2}} </li>
          </ul>
        </q-td>
      </template>
      <template v-slot:body-cell-Categorias="props">
        <q-td :props="props" auto-width>
          <ul style="list-style: none">
            <li v-if="props.row.controlRCPrimaria">controlRCPrimaria</li>
            <li v-if="props.row.seguidordelineaAmateur">seguidordelineaAmateur</li>
            <li v-if="props.row.minisumoRcAmateur">minisumoRcAmateur</li>
            <li v-if="props.row.minisumoAutonomoAmateur">minisumoAutonomoAmateur</li>
            <li v-if="props.row.carreradeInsectosAmateur">carreradeInsectosAmateur</li>
            <li v-if="props.row.peleadeRobotsAmateur">peleadeRobotsAmateur</li>
            <li v-if="props.row.minisumoAutonomoProfesional">minisumoAutonomoProfesional</li>
            <li v-if="props.row.minisumoRcProfesional">minisumoRcProfesional</li>
            <li v-if="props.row.microsumoProfesional">microsumoProfesional</li>
            <li v-if="props.row.seguidordelineaProfesional">seguidordelineaProfesional</li>
            <li v-if="props.row.carreradeInsectosProfesional">carreradeInsectosProfesional</li>
            <li v-if="props.row.creatividadeInnovacionTecnologicaProyectos">creatividadeInnovacionTecnologicaProyectos</li>
            <li v-if="props.row.guerradeRobotsProfesional1Lb">guerradeRobotsProfesional1Lb</li>
            <li v-if="props.row.autoaControlRCBluetooth">autoaControlRCBluetooth</li>
            <li v-if="props.row.robotSoccer">robotSoccer</li>
          </ul>
        </q-td>
      </template>
    </q-table>
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
      url:process.env.API,
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

      participanteColumns:[
        {label: 'Opciones', field: 'Opciones',name:'Opciones',sortable:true},
        {label: 'Participantes', field: 'Participantes',name:'Participantes',sortable:true,align: 'left'},
        {label: 'nombre1', field: 'nombre1',name:'nombre1',sortable:true,classes:'hidden', headerClasses:'hidden',},
        {label: 'nombre2', field: 'nombre2',name:'nombre2',sortable:true,classes:'hidden', headerClasses:'hidden',},
        {label: 'club', field: 'club',name:'club',sortable:true},
        {label: 'Categorias', field: 'Categorias',name:'Categorias',align:'left',sortable:true},
      ],
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
    async printCertificado(participante) {
      let doc = new jsPDF('landscape', null, 'letter');
      let logo = new Image();
      logo.src = 'certificado.jpg';

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

        doc.addImage(qrImage, 'png', 235, 135, 25, 25);
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

        doc.addImage(qrImage, 'png', 235, 135, 25, 25);
      }
      if(participante.club!=null){
      doc.addPage();
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
        doc.addImage(qrImage, 'png', 235, 135, 25, 25);
      }
        doc.save('Certificado.pdf')

    },

    
 

    participantesGet(){
      this.loading=true
      this.$api.get(`listparticipante`).then(res => {
        this.loading=false
        this.participantes = res.data
      })
    }
  }
}
</script>

<style scoped>

</style>
