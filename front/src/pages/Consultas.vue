<template>
<q-page>
<div class="row">
  <div class="col-12 col-sm-6">
    <q-select dense outlined label="Categoria" @update:model-value="participanteDatos" v-model="categoria" :options="categorias" />
  </div>
  <div class="col-12 col-sm-6 flex flex-center">
    <q-btn dense outlined label="Actualizar" :loading="loading" color="info" class="full-width" icon="refresh" @click="participanteDatos(categoria)" />
  </div>
  <div class="col-12 col-sm-12">
    <q-table dense :rows-per-page-options="[0]" :rows="participantes" :columns="participantesColumns">
      <template v-slot:body-cell-participantes="props">
        <q-td :props="props" auto-width>
          <ul style="list-style: none;padding: 0px;margin: 0px;border: 0px">
            <li>{{props.row.participante.nombre1}} {{edad(props.row.participante.fechaNac1)}}A</li>
            <li>{{props.row.participante.nombre2}} {{edad(props.row.participante.fechaNac2)}}A</li>
          </ul>
        </q-td>
      </template>
      <template v-slot:body-cell-n="props">
        <q-td :props="props" auto-width>
          <div class="text-bold">{{props.pageIndex+1}}</div>
        </q-td>
      </template>
      <template v-slot:top-right>
        <q-btn
          :disable="participantes.length == 0"
          :loading="loading"
          color="primary"
          icon-right="archive"
          label="Export excel"
          no-caps
          @click="exportXml"
        />
      </template>
    </q-table>
    <pre>{{participantes}}</pre>
  </div>
</div>
</q-page>
</template>

<script>
import moment from "moment/moment";
let xlsx = require("json-as-xlsx")
import { exportFile, useQuasar } from 'quasar'
function wrapCsvValue (val, formatFn, row) {
  let formatted = formatFn !== void 0
    ? formatFn(val, row)
    : val

  formatted = formatted === void 0 || formatted === null
    ? ''
    : String(formatted)

  formatted = formatted.split('"').join('""')
  /**
   * Excel accepts \n and \r in strings, but some other CSV parsers do not
   * Uncomment the next two lines to escape new lines
   */
  // .split('\n').join('\\n')
  // .split('\r').join('\\r')

  return `"${formatted}"`
}
export default {
  name: `Consultas`,
  data() {
    return {
      participante:{},
      participantes:[],
      categoria: '',
      participantesColumms:[

      ],
      participantesColumns:[
        {name:'n', label: 'n',field: 'n', sortable: true},
        {name:'participantes', label: 'participantes',field: 'participantes', align: 'left', sortable: true},
        {name:'punto', label: 'punto',field: 'punto', sortable: true},
        {name:'categoria', label: 'categoria',field: 'categoria', align: 'center', sortable: true},
        {name:'user', label: 'user',field: row=>row.user.name, align: 'center', sortable: true},
        {name:'fecha', label: 'fecha',field: 'fecha', align: 'center', sortable: true},
      ],
      loading: false,
      categorias: [
        'controlRCPrimaria',
        'seguidordelineaAmateur',
        'minisumoRcAmateur',
        'minisumoAutonomoAmateur',
        'carreradeInsectosAmateur',
        'peleadeRobotsAmateur',
        'minisumoAutonomoProfesional',
        'minisumoRcProfesional',
        'microsumoProfesional',
        'seguidordelineaProfesional',
        'carreradeInsectosProfesional',
        'creatividadeInnovacionTecnologicaProyectos',
        'guerradeRobotsProfesional1Lb',
        'autoaControlRCBluetooth',
        'robotSoccer',
      ]
    }
  },
  created() {

  },
  methods: {
    exportXml() {
      let data = [
        {
          sheet: this.categoria,
          columns: [
            { label: "n", value: "n" }, // Top level data
            { label: "competidores", value: "competidores" },
            { label: "punto", value: "punto" },
            { label: "categoria", value: "categoria" },
            { label: "user", value: row=>row.user.name },
            { label: "fecha", value: "fecha" },
          ],
          content: this.participantes,
        },
      ]

      let settings = {
        fileName: this.categoria, // Name of the resulting spreadsheet
        extraLength: 6, // A bigger number means that columns will be wider
        writeOptions: {}, // Style options from https://github.com/SheetJS/sheetjs#writing-options
      }

      xlsx(data, settings) // Will download the excel file
    },
    exportTable () {
      // naive encoding to csv format
      const content = [this.participantesColumns.map(col => wrapCsvValue(col.label))].concat(
        this.participantes.map(row => this.participantesColumns.map(col => wrapCsvValue(
          typeof col.field === 'function'
            ? col.field(row)
            : row[ col.field === void 0 ? col.name : col.field ],
          col.format,
          row
        )).join(','))
      ).join('\r\n')

      const status = exportFile(
        'table-export.csv',
        content,
        'text/csv'
      )

      if (status !== true) {
        $q.notify({
          message: 'Browser denied file download...',
          color: 'negative',
          icon: 'warning'
        })
      }
    },
    edad(fecha){
      let nacimiento=moment(fecha);
      let hoy=moment();
      return hoy.diff(nacimiento,"years");
    },
    participanteDatos(categoria){
      if (categoria==''){
        this.$q.notify({
          color: 'red-6',
          textColor: 'white',
          icon: 'error',
          message: 'Seleccione una categoria',
          position: 'top',
          timeout: 4000
        })
        return
      }
      this.loading=true
      this.participantes=[]
      this.$api.get('participante/'+categoria).then(response => {
        this.loading=false
        let con=1
        response.data.forEach(participante => {
          participante.n=con

          participante.competidores=participante.participante.nombre1+' '+participante.participante.nombre2
          con++
        });
        this.participantes = response.data;
      })
    }
  },
}
</script>

<style scoped>

</style>
