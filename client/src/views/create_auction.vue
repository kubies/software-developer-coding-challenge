<template>
  <el-form ref="form" label-width="120px">
    <el-form-item label="VIN">
      <el-input v-model="vin"></el-input>
    </el-form-item>
    <el-form-item label="Make">
      <el-input v-model="make"></el-input>
    </el-form-item>
    <el-form-item label="Model">
      <el-input v-model="model"></el-input>
    </el-form-item>
    <el-form-item label="Style">
      <el-input v-model="style"></el-input>
    </el-form-item>
    <el-form-item label="Year">
      <el-input-number v-model="year"></el-input-number>
    </el-form-item>
    <el-form-item label="Seats">
      <el-input-number v-model="seats"></el-input-number>
    </el-form-item>
    <el-form-item label="Doors">
      <el-input-number v-model="doors"></el-input-number>
    </el-form-item>
    <el-form-item label="Engine">
      <el-input v-model="engine"></el-input>
    </el-form-item>
    <el-form-item label="Transmission">
      <el-input v-model="transmission"></el-input>
    </el-form-item>
    <el-form-item label="Body">
      <el-select v-model="body" placeholder="Select">
        <el-option
          v-for="item in bodies"
          :key="item.value"
          :label="item.label"
          :value="item.value">
        </el-option>
      </el-select>
    </el-form-item>
    <el-form-item label="Interior Color">
      <el-input v-model="interior_color"></el-input>
    </el-form-item>
    <el-form-item label="Exterior Color">
      <el-input v-model="exterior_color"></el-input>
    </el-form-item>
    <el-form-item label="Odometer">
      <el-input v-model="odometer"></el-input>
    </el-form-item>
    <el-form-item label="Start Price">
      <el-input v-model="start_price"></el-input>
    </el-form-item>
    <el-form-item label="Bid Increment">
      <el-input v-model="bid_increment"></el-input>
    </el-form-item>
    <el-form-item>
      <el-checkbox v-model="as_is">As Is</el-checkbox>
    </el-form-item>
    <el-form-item>
      <el-button type="success" @click="create">Create</el-button>
      <el-button @click="$router.push({path: '/'})">Cancel</el-button>
    </el-form-item>
  </el-form>
</template>

<script>
export default {
  name: "create_auction",
  data() {
    return {
      vin: '',
      make: '',
      model: '',
      style: '',
      year: (new Date()).getFullYear() - 1,
      seats: 5,
      doors: 4,
      engine: '',
      transmission: '',
      body: '',
      interior_color: '',
      exterior_color: '',
      odometer: '',
      start_price: '',
      bid_increment: '',
      as_is: false,

      bodies: [
        {label: 'Convertible', value: 'convertible'},
        {label: 'Truck', value: 'truck'},
        {label: 'Van', value: 'van'},
        {label: 'Wagon', value: 'wagon'},
        {label: 'SUV', value: 'suv'},
        {label: 'Coupe', value: 'coupe'},
        {label: 'Sedan', value: 'sedan'},
        {label: 'Crossover', value: 'crossover'},
        {label: 'Minivan', value: 'minivan'},
        {label: 'Truck Crew Cab', value: 'truck_crew_cab'},
        {label: 'Truck Extended Cab', value: 'truck_extended_cab'},
        {label: 'Truck Long Regular Cab', value: 'truck_long_regular_cab'},
        {label: 'Motorcycle', value: 'motorcycle'},
        {label: 'Cargo Van', value: 'cargo_van'},
        {label: 'Commercial', value: 'commercial'},
        {label: 'Trailer', value: 'trailer'},
        {label: 'Hatchback', value: 'hatchback'},
      ]
    }
  },
  methods: {
    create() {

    }
  }
}
</script>

<style scoped>

</style>
