import Api from '@/Helpers/Api/Api.js';
import Store from '@/Store';
import SystemVars from '@/Helpers/General/SystemVars';
//import router from '@/router'

let Auth = {
  async login(data) {
      let result = await Api.postAsync('/auth/login', data);

      if (result.code == 200) {
        Store.dispatch('setToken', result.response.token);
        //router.push('/dashboard');
        window.location.assign(SystemVars.baseUrl + 'dashboard');
      } else {
        console.error (result.response);
      }
  },
  async logout() {
    let result = await Api.postAsync('/auth/logout');
    Store.dispatch('removeToken');

    if (result.code == 200) {
      Store.dispatch('removeToken');
      router.go();
    } else {
      console.error (result.response);
    }
  },
  async register(data) {
    let result = await Api.postAsync('/auth/register', data);

    if (result.code == 200) {
      Store.dispatch('setToken', result.response.token);
      router.go();
    } else {
      console.error (result.response);
    }
  },
  verifyUserToken() {
    Api.get('/user/token')
    .then(response => {
      // JSON responses are automatically parsed.
      return response.data
    })
    .catch(e => {
      return this.errors.push(e)
    })
  },
}

export default Auth;
