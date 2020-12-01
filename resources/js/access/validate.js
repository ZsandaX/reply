export default function check(name, item) {
    return axios.post(`${name}/check`, item).then(response => {
        if (response.data.success == false) {
            throw response.data.errors;
        }
        return response;
    })
};
