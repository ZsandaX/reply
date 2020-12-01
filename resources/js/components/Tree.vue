<template>
    <div v-loading="loading">
        <el-button type="primary" icon="el-icon-circle-plus" @click="create">
            新增
        </el-button>
        <slot name="control">

        </slot>
        <Node
            :parent-id="null"
            :level="1"
            :data="data"
            @edit="edit"
            @update="update"
            @destroy="destroy"
        />
        <slot name="dialog">
            <el-dialog
                v-if="dialogVisible"
                :title="dialogTitle"
                :visible.sync="dialogVisible"
                :close-on-click-modal="false"
                append-to-body
            >
                <Form :model="editableItem" :name="name" @refresh="index" />
            </el-dialog>
        </slot>
    </div>
</template>

<script>
export default {
    props: {
        name: String,
        value: Array,
    },
    created() {
        this.index();
    },
    data() {
        return {
            dialogTitle: "",
            dialogVisible: false,
            data: [],
            editableItem: {},
            loading: false,
        };
    },
    methods: {
        check(item) {
            axios
                .post(`${this.name}/check`, item)
                .then((response) => {
                    this.$message.success("更新成功");
                })
                .catch((error) => {
                    this.$message.error("更新失敗");
                });
        },
        submit(item) {
            if (item.hasOwnProperty("id")) {
                this.update(item);
            } else {
                this.store(item);
            }
        },
        index() {
            this.loading = true;
            let params = {
                mode: "tree",
            };
            axios
                .get(`${this.name}`, { params })
                .then((response) => {
                    this.loading = false;
                    this.data = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        create() {
            this.dialogVisible = true;
            this.dialogTitle = "新增資料";
            this.editableItem = {};
        },
        edit(item) {
            this.dialogVisible = true;
            this.dialogTitle = "編輯資料";
            this.editableItem = item;
        },
        update(item) {
            axios
                .put(`${this.name}/${item.id}`, item)
                .then((response) => {
                    this.index();
                    this.$message.success("更新成功");
                })
                .catch((error) => {
                    this.$message.error("更新失敗");
                });
        },
        destroy(item) {
            axios
                .delete(`${this.name}/${item.id}`)
                .then((response) => {
                    this.index();
                    this.$message.success("刪除成功");
                })
                .catch((error) => {
                    this.$message.error("刪除失敗");
                });
        },
    },
};
</script>
