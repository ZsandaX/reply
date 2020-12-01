export default function update(name, item) {
    return axios.put(`${name}/${item.id}`, item).then(response => {
        if (response.data.success == false) {
            throw response.data.errors;
        }
        return response;
    });
};
