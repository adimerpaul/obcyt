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
        <q-td :props="props" auto-width>
          <q-btn-dropdown color="primary" :label="$q.screen.lt.md?'':'Opciones'">
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
              <q-item clickable v-close-popup @click="credencialUser1(props.row.nombre1,props.row.fechaNac1,props.row,props.row.foto1)">
                <q-item-section>
                  <q-item-label>Credencial Participante 1</q-item-label>
                </q-item-section>
              </q-item>
              <q-item clickable v-close-popup @click="credencialUser1(props.row.nombre2,props.row.fechaNac2,props.row,props.row.foto2)">
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
        <div class="text-h6">Modificar Competidor</div>
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
  <q-dialog v-model="participanteDatosDialog" full-width>
    <q-card >
      <q-card-section class="row items-center q-pb-none">
        <div class="text-bold">{{participante.nombre1}}-{{participante.nombre2}}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>
      <q-card-section>
        <q-form @submit.prevent="datoInsert">
          <div class="row">
            <div class="col-12 col-sm-3">
              <q-select required label="seleccionar Categoria" v-model="dato.categoria" dense outlined :options="datoOpcion"/>
            </div>
            <div class="col-12 col-sm-3">
              <q-input dense outlined label="descipcion" v-model="dato.descripcion"/>
            </div>
            <div class="col-12 col-sm-3">
              <q-input dense type="number" requerido outlined step="0.01" label="punto" v-model="dato.punto"/>
            </div>
            <div class="col-12 col-sm-3">
              <div class="row">
                <div class="col-6"><q-btn label="Agregar" icon="o_send" :loading="loading" type="submit" color="green-9" class="full-width" /></div>
                <div class="col-6"><q-btn label="Actualizar" icon="refresh" :loading="loading" @click="datos(this.participante)" color="info" class="full-width" /></div>
              </div>
            </div>
            <div class="col-12">
              <q-table dense :rows-per-page-options="[0]" :rows="puntos" :columns="puntosColumns">
                <template v-slot:body-cell-opcion="props">
                  <q-td auto-width :props="props">
                    <q-btn dense flat color="red-9" icon="o_delete" @click="datoEliminar(props.row)"/>
                  </q-td>
                </template>
              </q-table>
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
      puntosColumns:[
        {name:'opcion',label:'opcion',field:'opcion',sortable:true,align:'left'},
        {name:'categoria',label:'categoria',field:'categoria',sortable:true,align:'left'},
        {name:'descripcion',label:'descripcion',field:'descripcion',sortable:true,align:'left'},
        {name:'punto',label:'punto',field:'punto',sortable:true},
        {name:'user',label:'user',field:row=>row.user.name,sortable:true,align:'left'},
        {name:'fecha',label:'fecha',field:'fecha',sortable:true},
      ],
      participanteColumns:[
        {label: 'Opciones', field: 'Opciones',name:'Opciones',sortable:true},
        {label: 'Participantes', field: 'Participantes',name:'Participantes',sortable:true,align: 'left'},
        {label: 'categoria', field: 'categoria',name:'categoria',sortable:true},
        {label: 'nombre1', field: 'nombre1',name:'nombre1',sortable:true,classes:'hidden', headerClasses:'hidden',},
        {label: 'nombre2', field: 'nombre2',name:'nombre2',sortable:true,classes:'hidden', headerClasses:'hidden',},
        {label: 'club', field: 'club',name:'club',sortable:true},
        {label: 'Categorias', field: 'Categorias',name:'Categorias',align:'left',sortable:true},
        {label: 'id', field: 'id',name:'id',sortable:true},
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
    datos(participante){
      this.loading = true
      participante.controlRCPrimaria==1?this.datoOpcion.push('controlRCPrimaria'):1
      participante.seguidordelineaAmateur==1?this.datoOpcion.push('seguidordelineaAmateur'):1
      participante.minisumoRcAmateur==1?this.datoOpcion.push('minisumoRcAmateur'):1
      participante.minisumoAutonomoAmateur==1?this.datoOpcion.push('minisumoAutonomoAmateur'):1
      participante.carreradeInsectosAmateur==1?this.datoOpcion.push('carreradeInsectosAmateur'):1
      participante.peleadeRobotsAmateur==1?this.datoOpcion.push('peleadeRobotsAmateur'):1
      participante.minisumoAutonomoProfesional==1?this.datoOpcion.push('minisumoAutonomoProfesional'):1
      participante.minisumoRcProfesional==1?this.datoOpcion.push('minisumoRcProfesional'):1
      participante.microsumoProfesional==1?this.datoOpcion.push('microsumoProfesional'):1
      participante.seguidordelineaProfesional==1?this.datoOpcion.push('seguidordelineaProfesional'):1
      participante.carreradeInsectosProfesional==1?this.datoOpcion.push('carreradeInsectosProfesional'):1
      participante.creatividadeInnovacionTecnologicaProyectos==1?this.datoOpcion.push('creatividadeInnovacionTecnologicaProyectos'):1
      participante.guerradeRobotsProfesional1Lb==1?this.datoOpcion.push('guerradeRobotsProfesional1Lb'):1
      participante.autoaControlRCBluetooth==1?this.datoOpcion.push('autoaControlRCBluetooth'):1
      participante.robotSoccer==1?this.datoOpcion.push('robotSoccer'):1
      this.participante=participante
      this.participanteDatosDialog=true
      this.puntos=[]
      this.$api.get(`puntos/${participante.id}`).then((res)=>{
        this.puntos=res.data
        this.loading = false
      })
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
      this.participanteDialog=true
      this.participante={
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
      }
    },
    participanteModificar(participante){
      // console.log(participante)
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
    async printCertificado(nombre, participante) {
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
      let doc = new jsPDF('landscape', null, 'letter');
      let logo = new Image();
      logo.src = 'certificado.jpg';
      doc.addImage(logo, 'JPEG', 0, 0, 280, 210);
      doc.setFont('times')
      doc.setFontSize(13, 'normal')
      doc.text('Se otorga el presente certificado A:', 30, 70)
      doc.setFontSize(20, 'bold')
      doc.text(nombre == null ? '' : nombre, 140, 80, 'center')
      doc.setFontSize(13, 'normal')
      doc.text('Por la participación en Olimpiada Boliviana de Ciencia y Tecnología BALLIVIANITOBOT en calidad de:', 30, 90)
      doc.setFontSize(20, 'bold')
      doc.text(participante.categoria == null ? '' : participante.categoria, 140, 100, 'center')
      doc.setFontSize(13, 'normal')
      doc.text("Con las participaciones en la(s) categoría(s):" + categorias, 30, 110, {
        maxWidth: 220,
        align: "justify"
      }); // to justify

      let nom=nombre==null?'':nombre
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
      setTimeout(() => {
        // let base64Image = $('#qr_code img').attr('src');
        doc.addImage(qrImage, 'png', 235, 135, 25, 25);
        // console.log(producer)
        doc.save('Certificado '+nom+'.pdf')
        // window.open(doc.output('bloburl'), '_blank')
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
