export function getAuctions() {
  let users = []
  let auctions = []
  return new Promise((resolve, reject) => {
    const promises = []
    promises.push (axios.get('http://localhost:8000/api/users').then(result=>{
      if(result.data) {
        users = result.data
      }
    }))
    promises.push(axios.get('http://localhost:8000/api/auctions').then(result => {
      if(result.data) {
        auctions = result.data
      }
    }))

    Promise.all(promises).then(result => {
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
    // const auctions_promise = axios.get('http://localhost:8000/api/auctions').then()
    // axios.get('http://localhost:8000/api/users').then(result=>{
    //   if(result.data) {
    //     users = result.data
    //     return axios.get('http://localhost:8000/api/auctions')
    //   }
    //   reject({
    //     "error" : [
    //       "Cannot receive data from server"
    //     ]
    //   })
    // }).then(result => {
    //   if(result.data) {
    //     auctions = result.data
    //     const output = []
    //     auctions.forEach()
    //     resolve(result)
    //   }
    //   reject({
    //     "error" : [
    //       "Cannot receive data from server"
    //       ]
    //   })
    // }).catch(error => {
    //   reject(error)
    // })
  });

  // try {
  //   const output = []
  //   const users = await axios.get('http://localhost:8000/api/users').data
  //   const auctions = await axios.get('http://localhost:8000/api/users').data
  //   for(let i =0; i < auctions.length; i++) {
  //     const auction = auctions[i]
  //     auction['created_by'] = users.find(user => user.id === auction['created_by'])
  //     output.push(auction)
  //   }
  //   return output
  // } catch (e) {
  //   throw e
  // }
}
