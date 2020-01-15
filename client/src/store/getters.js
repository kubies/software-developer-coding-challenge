export const getters = {
  token: state => state.user.token,
  user: state => state.user.user,
  authenticated: state => state.user.token !== null
}
