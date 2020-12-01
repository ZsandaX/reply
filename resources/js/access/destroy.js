export default function destroy(name, id){
    return axios.delete(`${name}/${id}`);
};
