export default function store(name, item) {
    return axios.post(`${name}`, item).then(response=>{
        if(response.data.success == false){
            throw response.data.errors;
        }
        return response;
    })
};
