<template>
<q-page>
<div class="row">
  <div class="col-12">
    <q-table dense :rows="participantes" :columns="participanteColumns" :rows-per-page-options="[0]" :filter="participanteFilter">
      <template v-slot:top-right>
        <q-btn color="green" @click="participanteDialog=true" icon="add_circle_outline" label="Registrar" />
        <q-input dense outlined v-model="participanteFilter" placeholder="Buscar">
          <template v-slot:prepend>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>
      <template v-slot:body-cell-Opciones="props">
        <q-td :props="props" auto-width>
          <q-btn-dropdown color="primary" label="OPCIONES">
            <q-list>
              <q-item clickable v-close-popup @click="participanteModificar(props.row)">
                <q-item-section>
                  <q-item-label>Modificar</q-item-label>
                </q-item-section>
              </q-item>

              <q-item clickable v-close-popup @click="certificadoClub(props.row)">
                <q-item-section>
                  <q-item-label>Certificado del club</q-item-label>
                </q-item-section>
              </q-item>

              <q-item clickable v-close-popup @click="certificadoUser1(props.row)">
                <q-item-section>
                  <q-item-label>Certificado Participante 1</q-item-label>
                </q-item-section>
              </q-item>
              <q-item clickable v-close-popup @click="certificadoUser2(props.row)">
                <q-item-section>
                  <q-item-label>Certificado Participante 2</q-item-label>
                </q-item-section>
              </q-item>
              <q-item clickable v-close-popup @click="credencialUser1(props.row)">
                <q-item-section>
                  <q-item-label>Credencial Participante 1</q-item-label>
                </q-item-section>
              </q-item>
              <q-item clickable v-close-popup @click="credencialUser2(props.row)">
                <q-item-section>
                  <q-item-label>Credencial Participante 2</q-item-label>
                </q-item-section>
              </q-item>
              <q-item clickable v-close-popup @click="datos(props.row)">
                <q-item-section>
                  <q-item-label>Inserción de puntos</q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
          </q-btn-dropdown>
        </q-td>
      </template>
      <template v-slot:body-cell-Participantes="props">
        <q-td :props="props" auto-width>
          <ul style="list-style: none">
            <li>1.-{{props.row.nombre1}} {{edad(props.row.fechaNac1)}}Años</li>
            <li>2.-{{props.row.nombre2}} {{edad(props.row.fechaNac2)}}Años</li>
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
    <pre>{{participantes}}</pre>
  </div>
</div>
<q-dialog v-model="participanteDialog" full-width>
  <q-card >
    <q-card-section class="row items-center q-pb-none q-mb-none">
      <div class="text-h6">Registrar Competidor</div>
      <q-space/>
      <q-btn flat dense round v-close-popup icon="close"/>
    </q-card-section>
    <q-card-section>
      <q-form @submit.prevent="participanteCreate">
      <div class="row">
        <div class="col-12"><q-input dense outlined label="nombre1" name="nombre1" v-model="participante.nombre1" required/></div>
        <div class="col-12 flex flex-center">
          <q-uploader
            accept=".jpg, .png"
            @added="uploadFile"
            auto-upload
            max-files="1"
            label="Ingresar imagen participante1"
            flat
            max-file-size="2000000"
            @rejected="onRejected"
            bordered
          />
        </div>
        <div class="col-12"><q-input dense outlined type="date" label="fechaNac1" name="fechaNac1" v-model="participante.fechaNac1"/></div>
        <div class="col-12"><q-input dense outlined label="nombre2" name="nombre2" v-model="participante.nombre2"/></div>
        <div class="col-12 flex flex-center">
          <q-uploader
            accept=".jpg, .png"
            @added="uploadFile2"
            auto-upload
            max-files="1"
            label="Ingresar imagen participante2"
            flat
            max-file-size="2000000"
            @rejected="onRejected"
            bordered
          />
        </div>
        <div class="col-12"><q-input dense outlined type="date" label="fechaNac2" name="fechaNac2" v-model="participante.fechaNac2"/></div>
        <div class="col-12"><q-input dense outlined label="club" name="club" v-model="participante.club"/></div>
        <div class="col-12"><q-input dense outlined label="correo" name="correo" v-model="participante.correo" type="email" /></div>
        <div class="col-12"><q-input dense outlined label="celular" name="celular" v-model="participante.celular"/></div>
        <div class="col-12 flex flex-center">
          <q-uploader
            accept=".jpg, .png"
            @added="uploadFile3"
            auto-upload
            max-files="1"
            label="Ingresar imagen logo club"
            flat
            max-file-size="2000000"
            @rejected="onRejected"
            bordered
          />
        </div>
        <div class="col-12"><q-checkbox dense outlined label="controlRCPrimaria" name="controlRCPrimaria" v-model="participante.controlRCPrimaria"/></div>
        <div class="col-12"><q-checkbox dense outlined label="seguidordelineaAmateur" name="seguidordelineaAmateur" v-model="participante.seguidordelineaAmateur"/></div>
        <div class="col-12"><q-checkbox dense outlined label="minisumoRcAmateur" name="minisumoRcAmateur" v-model="participante.minisumoRcAmateur"/></div>
        <div class="col-12"><q-checkbox dense outlined label="minisumoAutonomoAmateur" name="minisumoAutonomoAmateur" v-model="participante.minisumoAutonomoAmateur"/></div>
        <div class="col-12"><q-checkbox dense outlined label="carreradeInsectosAmateur" name="carreradeInsectosAmateur" v-model="participante.carreradeInsectosAmateur"/></div>
        <div class="col-12"><q-checkbox dense outlined label="peleadeRobotsAmateur" name="peleadeRobotsAmateur" v-model="participante.peleadeRobotsAmateur"/></div>
        <div class="col-12"><q-checkbox dense outlined label="minisumoAutonomoProfesional" name="minisumoAutonomoProfesional" v-model="participante.minisumoAutonomoProfesional"/></div>
        <div class="col-12"><q-checkbox dense outlined label="minisumoRcProfesional" name="minisumoRcProfesional" v-model="participante.minisumoRcProfesional"/></div>
        <div class="col-12"><q-checkbox dense outlined label="microsumoProfesional" name="microsumoProfesional" v-model="participante.microsumoProfesional"/></div>
        <div class="col-12"><q-checkbox dense outlined label="seguidordelineaProfesional" name="seguidordelineaProfesional" v-model="participante.seguidordelineaProfesional"/></div>
        <div class="col-12"><q-checkbox dense outlined label="carreradeInsectosProfesional" name="carreradeInsectosProfesional" v-model="participante.carreradeInsectosProfesional"/></div>
        <div class="col-12"><q-checkbox dense outlined label="creatividadeInnovacionTecnologicaProyectos" name="creatividadeInnovacionTecnologicaProyectos" v-model="participante.creatividadeInnovacionTecnologicaProyectos"/></div>
        <div class="col-12"><q-checkbox dense outlined label="guerradeRobotsProfesional1Lb" name="guerradeRobotsProfesional1Lb" v-model="participante.guerradeRobotsProfesional1Lb"/></div>
        <div class="col-12"><q-checkbox dense outlined label="autoaControlRCBluetooth" name="autoaControlRCBluetooth" v-model="participante.autoaControlRCBluetooth"/></div>
        <div class="col-12"><q-checkbox dense outlined label="robotSoccer" name="robotSoccer" v-model="participante.robotSoccer"/></div>
        <div class="col-12">
          <q-btn label="Guardar" :loading="loading" icon="add_circle_outline" type="submit" color="green" class="full-width" />
        </div>
      </div>
      </q-form>
    </q-card-section>
  </q-card>
</q-dialog>
<q-dialog v-model="participanteUpdateDialog" full-width>
    <q-card >
      <q-card-section class="row items-center q-pb-none q-mb-none">
        <div class="text-h6">Registrar Competidor</div>
        <q-space/>
        <q-btn flat dense round v-close-popup icon="close"/>
      </q-card-section>
      <q-card-section>
        <q-form @submit.prevent="participanteUpdate">
          <div class="row">
            <div class="col-12"><q-input dense outlined label="categoria" name="categoria" v-model="participante.categoria"/></div>
            <div class="col-12"><q-input dense outlined label="nombre1" name="nombre1" v-model="participante.nombre1" required/></div>
            <div class="col-12 flex flex-center">
              <q-uploader
                accept=".jpg, .png"
                @added="uploadFile"
                auto-upload
                max-files="1"
                label="Ingresar imagen participante1"
                flat
                max-file-size="2000000"
                @rejected="onRejected"
                bordered
              />
            </div>
            <div class="col-12"><q-input dense outlined type="date" label="fechaNac1" name="fechaNac1" v-model="participante.fechaNac1"/></div>
            <div class="col-12"><q-input dense outlined label="nombre2" name="nombre2" v-model="participante.nombre2"/></div>
            <div class="col-12 flex flex-center">
              <q-uploader
                accept=".jpg, .png"
                @added="uploadFile2"
                auto-upload
                max-files="1"
                label="Ingresar imagen participante2"
                flat
                max-file-size="2000000"
                @rejected="onRejected"
                bordered
              />
            </div>
            <div class="col-12"><q-input dense outlined type="date" label="fechaNac2" name="fechaNac2" v-model="participante.fechaNac2"/></div>
            <div class="col-12"><q-input dense outlined label="club" name="club" v-model="participante.club"/></div>
            <div class="col-12"><q-input dense outlined label="correo" name="correo" v-model="participante.correo" type="email" /></div>
            <div class="col-12"><q-input dense outlined label="celular" name="celular" v-model="participante.celular"/></div>
            <div class="col-12 flex flex-center">
              <q-uploader
                accept=".jpg, .png"
                @added="uploadFile3"
                auto-upload
                max-files="1"
                label="Ingresar imagen logo club"
                flat
                max-file-size="2000000"
                @rejected="onRejected"
                bordered
              />
            </div>
            <div class="col-12"><q-checkbox dense outlined label="controlRCPrimaria" name="controlRCPrimaria" v-model="participante.controlRCPrimaria"/></div>
            <div class="col-12"><q-checkbox dense outlined label="seguidordelineaAmateur" name="seguidordelineaAmateur" v-model="participante.seguidordelineaAmateur"/></div>
            <div class="col-12"><q-checkbox dense outlined label="minisumoRcAmateur" name="minisumoRcAmateur" v-model="participante.minisumoRcAmateur"/></div>
            <div class="col-12"><q-checkbox dense outlined label="minisumoAutonomoAmateur" name="minisumoAutonomoAmateur" v-model="participante.minisumoAutonomoAmateur"/></div>
            <div class="col-12"><q-checkbox dense outlined label="carreradeInsectosAmateur" name="carreradeInsectosAmateur" v-model="participante.carreradeInsectosAmateur"/></div>
            <div class="col-12"><q-checkbox dense outlined label="peleadeRobotsAmateur" name="peleadeRobotsAmateur" v-model="participante.peleadeRobotsAmateur"/></div>
            <div class="col-12"><q-checkbox dense outlined label="minisumoAutonomoProfesional" name="minisumoAutonomoProfesional" v-model="participante.minisumoAutonomoProfesional"/></div>
            <div class="col-12"><q-checkbox dense outlined label="minisumoRcProfesional" name="minisumoRcProfesional" v-model="participante.minisumoRcProfesional"/></div>
            <div class="col-12"><q-checkbox dense outlined label="microsumoProfesional" name="microsumoProfesional" v-model="participante.microsumoProfesional"/></div>
            <div class="col-12"><q-checkbox dense outlined label="seguidordelineaProfesional" name="seguidordelineaProfesional" v-model="participante.seguidordelineaProfesional"/></div>
            <div class="col-12"><q-checkbox dense outlined label="carreradeInsectosProfesional" name="carreradeInsectosProfesional" v-model="participante.carreradeInsectosProfesional"/></div>
            <div class="col-12"><q-checkbox dense outlined label="creatividadeInnovacionTecnologicaProyectos" name="creatividadeInnovacionTecnologicaProyectos" v-model="participante.creatividadeInnovacionTecnologicaProyectos"/></div>
            <div class="col-12"><q-checkbox dense outlined label="guerradeRobotsProfesional1Lb" name="guerradeRobotsProfesional1Lb" v-model="participante.guerradeRobotsProfesional1Lb"/></div>
            <div class="col-12"><q-checkbox dense outlined label="autoaControlRCBluetooth" name="autoaControlRCBluetooth" v-model="participante.autoaControlRCBluetooth"/></div>
            <div class="col-12"><q-checkbox dense outlined label="robotSoccer" name="robotSoccer" v-model="participante.robotSoccer"/></div>
            <div class="col-12">
              <q-btn label="Modificar" icon="o_send" :loading="loading" type="submit" color="yellow-9" class="full-width" />
            </div>
          </div>
        </q-form>
      </q-card-section>
    </q-card>
  </q-dialog>
  <div id="qr_code" style="display: none"></div>
</q-page>
</template>

<script>
import {date} from "quasar";
import moment from "moment";
import {jsPDF} from "jspdf";
import $ from "jquery";

export default {
  name: `Competidor`,
  data () {
    return {
      loading:false,
      participanteFilter:'',
      participanteDialog:false,
      participanteUpdateDialog:false,
      participantes: [],
      participanteColumns:[
        {label: 'Opciones', field: 'Opciones',name:'Opciones',sortable:true},
        {label: 'id', field: 'id',name:'id',sortable:true},
        {label: 'categoria', field: 'categoria',name:'categoria',sortable:true},
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
    credencialUser1(participante){
      this.participante=participante
      let doc = new jsPDF('landscape',null,'letter');
      let logo = new Image();
      logo.src = 'certificado.jpg';
      doc.addImage(logo, 'JPEG', 0, 0, 280, 210);
      doc.setFont('times')
      doc.setFontSize(13,'normal')
      doc.text( 'Se otorga el presente certificado A:',30, 70)
      doc.setFontSize(20,'bold')
      doc.text( nombre==null?'':nombre,140, 80,'center')
      doc.setFontSize(13,'normal')
      doc.text( 'Por la participación en Olimpiada Boliviana de Ciencia y Tecnología BALLIVIANITOBOT en calidad de:',30, 90)
      doc.setFontSize(20,'bold')
      doc.text( participante.categoria==null?'':participante.categoria,140, 100,'center')
      doc.setFontSize(13,'normal')

      let nom=nombre==null?'':nombre
      // doc.save('Certificado '+nom+'.pdf')
      var qrcode = new QRCode(document.getElementById("qr_code"), {
        text: "Nombre:"+nombre+"\nCategoria: "+participante.categoria,
        width: 128,
        height: 128,
        colorDark : "#000000",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
      });
      setTimeout(() => {
        let base64Image = $('#qr_code img').attr('src');
        doc.addImage(base64Image, 'png', 235, 135, 25, 25);
        // console.log(producer)
        window.open(doc.output('bloburl'), '_blank')
      }, 10);
    },
    credencialUser2(participante){
      this.participante=participante
    },
    participanteModificar(participante){
      console.log(participante)
      this.participante=participante
      this.participante.controlRCPrimaria=this.participante.controlRCPrimaria==1?true:false
      this.participante.seguidordelineaAmateur=this.participante.seguidordelineaAmateur==1?true:false
      this.participante.minisumoRcAmateur=this.participante.minisumoRcAmateur==1?true:false
      this.participante.minisumoAutonomoAmateur=this.participante.minisumoAutonomoAmateur==1?true:false
      this.participante.carreradeInsectosAmateur=this.participante.carreradeInsectosAmateur==1?true:false
      this.participante.peleadeRobotsAmateur=this.participante.peleadeRobotsAmateur==1?true:false
      this.participante.minisumoAutonomoProfesional=this.participante.minisumoAutonomoProfesional==1?true:false
      this.participante.minisumoRcProfesional=this.participante.minisumoRcProfesional==1?true:false
      this.participante.microsumoProfesional=this.participante.microsumoProfesional==1?true:false
      this.participante.seguidordelineaProfesional=this.participante.seguidordelineaProfesional==1?true:false
      this.participante.carreradeInsectosProfesional=this.participante.carreradeInsectosProfesional==1?true:false
      this.participante.creatividadeInnovacionTecnologicaProyectos=this.participante.creatividadeInnovacionTecnologicaProyectos==1?true:false
      this.participante.guerradeRobotsProfesional1Lb=this.participante.guerradeRobotsProfesional1Lb==1?true:false
      this.participante.autoaControlRCBluetooth=this.participante.autoaControlRCBluetooth==1?true:false
      this.participante.robotSoccer=this.participante.robotSoccer==1?true:false
      this.participanteUpdateDialog=true
    },
    edad(fecha){
      let nacimiento=moment(fecha);
      let hoy=moment();
      return hoy.diff(nacimiento,"years");
    },
    participanteUpdate(){
      this.loading=true
      this.$api.put('participante/'+this.participante.id, this.participante).then(res => {
        this.participantesGet()
        this.loading=false
        this.participanteUpdateDialog = false
      })
    },
    printCertificado(nombre,participante){
      let categorias=''
      categorias+=participante.controlRCPrimaria==1?" controlRCPrimaria,":''
      categorias+=participante.seguidordelineaAmateur==1?" seguidordelineaAmateur,":''
      categorias+=participante.minisumoRcAmateur==1?" minisumoRcAmateur,":''
      categorias+=participante.minisumoAutonomoAmateur==1?" minisumoAutonomoAmateur,":''
      categorias+=participante.carreradeInsectosAmateur==1?" carreradeInsectosAmateur,":''
      categorias+=participante.peleadeRobotsAmateur==1?" peleadeRobotsAmateur,":''
      categorias+=participante.minisumoAutonomoProfesional==1?" minisumoAutonomoProfesional,":''
      categorias+=participante.minisumoRcProfesional==1?" minisumoRcProfesional,":''
      categorias+=participante.microsumoProfesional==1?" microsumoProfesional,":''
      categorias+=participante.seguidordelineaProfesional==1?" seguidordelineaProfesional,":''
      categorias+=participante.carreradeInsectosProfesional==1?" carreradeInsectosProfesional,":''
      categorias+=participante.creatividadeInnovacionTecnologicaProyectos==1?" creatividadeInnovacionTecnologicaProyectos,":''
      categorias+=participante.guerradeRobotsProfesional1Lb==1?" guerradeRobotsProfesional1Lb,":''
      categorias+=participante.autoaControlRCBluetooth==1?" autoaControlRCBluetooth,":''
      categorias+=participante.robotSoccer==1?" robotSoccer,":''
      let doc = new jsPDF('landscape',null,'letter');
      let logo = new Image();
      logo.src = 'certificado.jpg';
      doc.addImage(logo, 'JPEG', 0, 0, 280, 210);
      doc.setFont('times')
      doc.setFontSize(13,'normal')
      doc.text( 'Se otorga el presente certificado A:',30, 70)
      doc.setFontSize(20,'bold')
      doc.text( nombre==null?'':nombre,140, 80,'center')
      doc.setFontSize(13,'normal')
      doc.text( 'Por la participación en Olimpiada Boliviana de Ciencia y Tecnología BALLIVIANITOBOT en calidad de:',30, 90)
      doc.setFontSize(20,'bold')
      doc.text( participante.categoria==null?'':participante.categoria,140, 100,'center')
      doc.setFontSize(13,'normal')
      doc.text("Con las participaciones en la(s) categoría(s):"+categorias, 30, 110, {maxWidth: 220, align: "justify"}); // to justify

      let nom=nombre==null?'':nombre
      // doc.save('Certificado '+nom+'.pdf')
      var qrcode = new QRCode(document.getElementById("qr_code"), {
        text: "Nombre:"+nombre+"\nCategoria: "+participante.categoria,
        width: 128,
        height: 128,
        colorDark : "#000000",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
      });
      setTimeout(() => {
        let base64Image = $('#qr_code img').attr('src');
        doc.addImage(base64Image, 'png', 235, 135, 25, 25);
        // console.log(producer)
        window.open(doc.output('bloburl'), '_blank')
      }, 10);
    },
    participanteCreate(){
      this.loading=true
      this.$api.post('participante', this.participante).then(res => {
        this.participantesGet()
        this.loading=false
        this.participanteDialog = false
      })
    },
    uploadFile (file) {
      let dialog = this.$q.dialog({
        message: 'Subiendo... 0%',
      })
      let percentage = 0
      const fd = new FormData()
      fd.append('file', file[0])
      return new Promise((resolve, reject) => {
        this.$api.post('upload',
          fd,
          {
            headers: { 'Content-Type': 'multipart/form-data' },
            onUploadProgress: (progressEvent) => {
              percentage = Math.round((progressEvent.loaded / progressEvent.total) * 100)
              dialog.update({
                message: `Subiendo... ${percentage}%`
              })
              if (percentage>=100){
                dialog.hide()
              }
            }
          })
          .then(res => {
            this.participante.foto1=res.data
            resolve(file)
          })
          .catch(err => reject(err))
      })
    },
    uploadFile2 (file) {
      let dialog = this.$q.dialog({
        message: 'Subiendo... 0%',
      })
      let percentage = 0
      const fd = new FormData()
      fd.append('file', file[0])
      return new Promise((resolve, reject) => {
        this.$api.post('upload',
          fd,
          {
            headers: { 'Content-Type': 'multipart/form-data' },
            onUploadProgress: (progressEvent) => {
              percentage = Math.round((progressEvent.loaded / progressEvent.total) * 100)
              dialog.update({
                message: `Subiendo... ${percentage}%`
              })
              if (percentage>=100){
                dialog.hide()
              }
            }
          })
          .then(res => {
            this.participante.foto2=res.data
            resolve(file)
          })
          .catch(err => reject(err))
      })
    },
    uploadFile3 (file) {
      let dialog = this.$q.dialog({
        message: 'Subiendo... 0%',
      })
      let percentage = 0
      const fd = new FormData()
      fd.append('file', file[0])
      return new Promise((resolve, reject) => {
        this.$api.post('upload',
          fd,
          {
            headers: { 'Content-Type': 'multipart/form-data' },
            onUploadProgress: (progressEvent) => {
              percentage = Math.round((progressEvent.loaded / progressEvent.total) * 100)
              dialog.update({
                message: `Subiendo... ${percentage}%`
              })
              if (percentage>=100){
                dialog.hide()
              }
            }
          })
          .then(res => {
            this.participante.imagen=res.data
            resolve(file)
          })
          .catch(err => reject(err))
      })
    },
    onRejected (rejectedEntries) {
      this.$q.notify({
        type: 'negative',
        message: `${rejectedEntries.length} el archivo paso las restricciones de validación`
      })
    },
    participantesGet(){
      this.$api.get(`participante`).then(res => {
        this.participantes = res.data
      })
    }
  }
}
</script>

<style scoped>

</style>
