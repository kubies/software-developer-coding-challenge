<template>
  <el-container>
    <el-row>
      <el-button style="float: right" v-if="$store.getters.authenticated" @click="$router.push({path:'/create'})">Create Auction</el-button>
    </el-row>
    <el-row>
      <el-table
        :data="auctions"
        style="width: 100%">
        <el-table-column
          prop="date"
          label="Date"
          width="180">
        </el-table-column>
        <el-table-column
          prop="name"
          label="Name"
          width="180">
        </el-table-column>
        <el-table-column
          prop="address"
          label="Address">
        </el-table-column>
      </el-table>
    </el-row>
  </el-container>
</template>

<script>
import {getAuctions} from '../api/auction.js'
export default {
  name: "auctions",
  data() {
      return {
        latest_first: false,
        search_filter: '',
        auctions: [],
        users:[],
      }
  },
  mounted() {
    this.loadServer()
  },
  methods: {
    loadServer() {
      getAuctions().then(result => {
        // this.auctions = result
        console.log(result)
      }).catch(err => {
        this.$message.error('Cannot load data from server')
      })
    }
  }
}
</script>

<style scoped>
  .el-container {
    padding: 50px;
    display: block;
  }

</style>
