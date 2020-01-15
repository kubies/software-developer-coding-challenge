<template>
  <el-container>
    <el-row>
      <el-button style="float: right" v-if="$store.getters.authenticated" @click="$router.push({path:'/create'})">Create Auction</el-button>
    </el-row>
    <el-row>
      <el-table
        empty-text="No Auction"
        v-loading="loading"
        :data="auctions"
        style="width: 100%">
        <el-table-column
          prop="created_at"
          :formatter="creationDateFormatter"
          label="Date">
        </el-table-column>
        <el-table-column
          prop="car"
          :formatter="carFormatter"
          label="Car Info">
        </el-table-column>
        <el-table-column
          prop="user.name"
          label="Created By">
        </el-table-column>
        <el-table-column
          prop="car.odometer"
          :formatter="kilometerFormatter"
          label="Odometer">
        </el-table-column>
        <el-table-column
          prop="highestBid"
          :formatter="priceFormatter"
          label="Price">
        </el-table-column>
        <el-table-column>
          <template slot-scope="scope">
            <el-button
              size="mini" @click="$router.push({name: 'auction', params: {auction_id: scope.row.id}})">View</el-button>
            <el-button
              size="mini"
              type="danger"
              v-if="$store.getters.authenticated && $store.getters.user !== null && $store.getters.user.id === scope.row.created_by"
              @click="handleDelete(scope.row)">Delete</el-button>
          </template>
        </el-table-column>
      </el-table>
    </el-row>
  </el-container>
</template>

<script>
import {getAuctions} from '../api/auction.js'
import * as formatter from '../utils/Formatter'
import {deleteAuction} from "../api/auction";
export default {
  name: "auctions",
  data() {
      return {
        search_filter: '',
        auctions: [],
        users:[],
        loading: false
      }
  },
  mounted() {
    this.loadServer()
  },
  methods: {
    loadServer() {
      this.loading = true
      getAuctions().then(result => {
        this.auctions = result.auctions
      }).catch(err => {
        this.$message.error('Cannot load data from server')
      }).finally(() => {
        this.loading = false
      })
    },
    creationDateFormatter(row, column) {return formatter.DateFormatter(row.created_at)},
    kilometerFormatter(row, col) {return formatter.KilometerFormatter(row.car.odometer)},
    priceFormatter(row, col) {return formatter.PriceFormatter(row.highestBid)},
    carFormatter(row, col) { return `${row.car.year} ${row.car.make} ${row.car.model}`},
    handleDelete(auction) {
      deleteAuction(auction.id).then(() => {
        let auction_idx = this.auctions.findIndex(a => a.id === auction.id)
        this.auctions.splice(auction_idx, 1)
      }).catch(err => {
        console.log(err.response)
        this.$message.error('Deleting auction failed')
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
