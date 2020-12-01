export default function edit(name, id) {
    return axios.get(`${name}/${id}/edit`);
};
