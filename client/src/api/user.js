import store from "../store";

export function login(data) {
  const {email, password} = data
  return axios.post('http://localhost:8000/api/login', {
    email,
    password
  })
}

export function logout() {
  return axios.post('http://localhost:8000/api/logout', null, {
    headers: {
      "Authorization" : "Bearer " + store.getters.token
    }
  })
}

export function register(data) {
  return axios.post('http://localhost:8000/api/register', data)
}

export function me() {
  return axios.get('http://localhost:8000/api/me', {
    headers: {
      "Authorization" : "Bearer " + store.getters.token
    }
  })
}
