export default function create(name){
    return axios.get(`${name}/create`);
};
