import Vue from 'vue';
export default {
    cadastrar (nome, login, senha, success, error) {
        Vue.axios.post('user', {
            name: nome,
            login: login,
            password: senha
        }).then((response) => {
            //verifica se a resposta é 200, 201, 202, ...
            if (Math.floor(response.status / 100) == 2) {
                localStorage.token = response.data.accessToken;
                if (success) success(response.data);
            }

            //error();
        }).catch((err) => {
            if (error) error(err);
        });
    },

    autenticar (login, senha, success, error) {
        Vue.axios.post('user/login', {
            login: login,
            password: senha
        }).then((response) => {
            if (response.status == 200) {
                if ((typeof response.data.accessToken != 'undefined') && (response.data.accessToken != '')) {
                    localStorage.accessToken = response.data.accessToken;
                    localStorage.user = response.data;
                    if (success) success(response.data);
                }
            } else error();
        }).catch(() => {
            if (error) error();
        });
    },

    get () {
        if ((typeof localStorage.user) != 'undefined') {
            return localStorage.user;
        }
        return null;
    }
}
