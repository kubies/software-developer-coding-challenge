import store from "../store";

export function getAuctions() {
  let users = {}
  let auctions = []
  let highest_bids = []
  return new Promise((resolve, reject) => {
    const promises = []
    promises.push (axios.get('http://localhost:8000/api/users').then(result=>{
      if(result.data) {
        // users = result.data
        result.data.forEach(user => {
          users[user.id] = user
        })
      }
    }))
    promises.push(axios.get('http://localhost:8000/api/auctions').then(result => {
      if(result.data) {
        auctions = result.data
      }
    }))

    Promise.all(promises).then(result => {
      auctions.forEach(auction => {
        auction['user'] = users[auction.created_by]
      })
      resolve({
        auctions,
        users
      })
    }).catch(error => {
      reject({
        "error" : [
          "Cannot receive data from server"
        ]
      })
    })
  });
}

export function createAuction(data) {
  return axios.post('http://localhost:8000/api/auction', data, {
    headers: {
      "Authorization" : "Bearer " + store.getters.token
    }
  })
}

export function getHighestBid(id) {
  return axios.get(`http://localhost:8000/api/auction/${id}/highestBid`, {
    headers: {
      "Authorization" : "Bearer " + store.getters.token
    }
  })
}

export function deleteAuction(id) {
  return axios.delete(`http://localhost:8000/api/auction/${id}`, {
    headers: {
      "Authorization" : "Bearer " + store.getters.token
    }
  })
}
