<template>
  <el-container style="padding-bottom: 40px;">
    <el-header style="display: flex; height: auto">
      <el-carousel trigger="click" height="600px" style="width: 100%">
        <el-carousel-item v-for="img in images" :key="img">
          <el-image style="margin-left: auto; margin-right: auto" :src="img" fit="scale-down"></el-image>
        </el-carousel-item>
      </el-carousel>

    </el-header>
    <el-main>
      <span class="ui red right ribbon label" style="left: calc(100% + 1rem + 20px);">AS-IS</span>
      <h2 class="ui dividing header">
        <span v-if="auction">
          {{carName}}
        </span>
        <div class="sub header">
          <div class="ui two column stackable grid" style="padding: 10px">
            <div class="column">
              <h4 class="row ui header" v-if="auction && auction.car.transmission">
                {{auction.car.transmission}}
              </h4>
              <h4 class="row ui header" v-if="auction && auction.car.odometer">
                {{kilometerFormatter(auction.car.odometer)}}
              </h4>
            </div>
            <div class="column" style="text-align: right">
              <h3 class="row ui header" v-if="auction">
                {{priceFormatter(auction.highestBid)}}
              </h3>
            </div>
          </div>
        </div>
        <div class="user-header">
          <div class="user-avatar">
            <img style="max-width: 100%;" src="https://media-exp1.licdn.com/dms/image/C5603AQHt3k-Mw7dIkg/profile-displayphoto-shrink_100_100/0?e=1584576000&v=beta&t=__3e2wYfSndMMa4MGGCi9CORNgzF1PSrenA7Hpso-5E">
          </div>
          <div class="user-basic-info" v-if="auction">
            <span class="user-nick">{{auction.user.name}}</span>
          </div>
        </div>
      </h2>
      <div class="details">
        <div class="detail" v-if="auction && auction.car.vin">
          <b>VIN: </b>
          {{auction.car.vin}}
        </div>
        <div class="detail" v-if="auction && auction.car.style">
          <b>Style: </b>
          {{auction.car.style}}
        </div>
        <div class="detail" v-if="auction && auction.car.body">
          <b>Body: </b>
          {{auction.car.body}}
        </div>
        <div class="detail" v-if="auction && auction.car.seats">
          <b>Seats: </b>
          {{auction.car.seats}}
        </div>
        <div class="detail" v-if="auction && auction.car.doors">
          <b>Doors: </b>
          {{auction.car.doors}}
        </div>
        <div class="detail"  v-if="auction && auction.car.engine">
          <b></b>
          {{auction.car.engine}}
        </div>
        <div class="detail" v-if="auction && auction.car.exterior_color">
          <b>Exterior Color</b>
          {{auction.car.exterior_color}}
        </div>
        <div class="detail" v-if="auction && auction.car.interior_color">
          <b>Interior Color</b>
          {{auction.car.interior_color}}
        </div>
      </div>

      <h3 class="ui header">
        Bids
        <el-button v-if="$store.getters.authenticated && $store.getters.user.id !== auction.created_by" :loading="saving" @click="placeBid" style="float: right">Place Bid</el-button>
      </h3>
      <el-timeline v-if="auction">
        <el-timeline-item
          v-for="(bid, idx) in auction.bids"
          :key="idx"
          :timestamp="bid.created_at">
          <b>{{priceFormatter(bid.amount)}}</b> - {{bid.user.name}}
        </el-timeline-item>
      </el-timeline>
    </el-main>
  </el-container>
</template>

<script>
  import {getAuction, placeBid} from "../api/auction";
    import * as formatter from "../utils/Formatter";

    export default {
      name: "auction",
      data() {
        return {
          loading: false,
          images: [
            'https://images.pexels.com/photos/1009871/pexels-photo-1009871.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260',
            'https://images.pexels.com/photos/1035108/pexels-photo-1035108.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260',
            'https://images.pexels.com/photos/1397751/pexels-photo-1397751.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260',
            'https://images.pexels.com/photos/533562/pexels-photo-533562.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'
          ],
          auction: null,
          saving: false
        }
      },
      created() {
        this.loadAuction(this.$route.params.auction_id)
      },
      beforeRouteUpdate(to, from, next) {
        this.loadAuction(to.params.auction_id)
        next()
      },
      methods: {
        loadAuction(id) {
          this.loading = true
          getAuction(id).then(result => {
            this.auction = result.auction
          }).catch(err => {
            this.$message.error(err.error[0])
          }).finally(() => {
            this.loading = false
          })
        },
        placeBid() {
          this.saving = true
          placeBid(this.auction.id).then(result => {
            const {data} = result
            let bids = []
            data['user'] = this.$store.getters.user
            bids.push(data)
            this.auction.bids.forEach(b => bids.push(b))
            this.auction['bids'] = bids
            this.auction.highestBid = data.amount
          }).catch(err => {
            this.$message.error('Operation failed')
          }).finally(() => {
            this.saving = false
          })
        },
        creationDateFormatter(date) {return formatter.DateFormatter(date)},
        kilometerFormatter(km) {return formatter.KilometerFormatter(km)},
        priceFormatter(price) {return formatter.PriceFormatter(price)},
      },
      computed: {
        carName() {
          return `${this.auction.car.year} ${this.auction.car.make} ${this.auction.car.model}`
        }
      }
    }
</script>

<style scoped>
  .el-container {
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
    margin-top: 60px;
  }
  .user-header {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    padding: 20px;
  }
  .user-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    font-size: 0;
    margin-right: 12px;
  }
  .user-basic-info {
    flex: 1;
    overflow: hidden;
    white-space: nowrap;
  }
  .user-nick {
    text-transform: uppercase;
    font-weight: 600;
    font-size: 15px;
    margin-bottom: 2px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  .user-fullname {
    color: rgba(51, 51, 51, 0.6);
    font-size: 14px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  .el-main {
    overflow: initial;
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.05) 0%, rgba(0, 0, 0, 0.05) 1%, rgba(0, 0, 0, 0) 100%);
    margin-left: 20px;
    margin-right: 20px;
    padding: 20px;
  }
</style>

<style scoped lang="scss">
  .details {
    display: flex;
    flex-wrap: wrap;
    .detail {
      display: inline-block;
      width: 50%;
      padding: 15px;
    }
  }
</style>
