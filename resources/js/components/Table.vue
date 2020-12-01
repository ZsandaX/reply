<template>
    <div v-loading="loading">
        <el-button type="primary" icon="el-icon-circle-plus" @click="create">
            新增
        </el-button>
        <slot name="control"> </slot>
        <el-table
            ref="multipleTable"
            :data="pagenate.data"
            @select="select"
            @select-all="select"
            style="width: 100%"
        >
            <el-table-column type="selection" width="55"></el-table-column>
            <el-table-column prop="id" label="序號"></el-table-column>
            <el-table-column
                :prop="prop"
                :label="column"
                v-for="(column, prop) of pagenate.columns"
                :key="prop"
            ></el-table-column>
            <el-table-column label="操作">
                <template v-slot="{ row }">
                    <el-dropdown trigger="click" @command="command">
                        <span class="el-dropdown-link">
                            <i class="el-icon-more text-secondary"></i>
                        </span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item
                                icon="el-icon-edit-outline"
                                :command="{ args: row, callback: edit }"
                            >
                                編輯
                            </el-dropdown-item>
                            <el-dropdown-item
                                icon="el-icon-delete"
                                :command="{
                                    args: row,
                                    callback: destroy,
                                }"
                            >
                                刪除
                            </el-dropdown-item>
                            <slot name="action" :row="row"></slot>
                        </el-dropdown-menu>
                    </el-dropdown>
                </template>
            </el-table-column>
        </el-table>
        <div class="d-flex justify-content-between">
            <el-pagination
                layout="slot, sizes, prev, pager, next, jumper, ->, total"
                :current-page.sync="pagenate.current_page"
                :page-size.sync="pagenate.per_page"
                :total="pagenate.total"
                @current-change="index"
                @size-change="index"
                class="text-center w-100"
            >
            </el-pagination>
        </div>

        <el-dialog
            v-if="dialogVisible"
            :title="dialogTitle"
            :visible.sync="dialogVisible"
            :close-on-click-modal="false"
            append-to-body
        >
            <slot name="dialog">
                <Form :model="editableItem" :name="name" @refresh="index" />
            </slot>
        </el-dialog>
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
            editableItem: {},
            pagenate: {},
            dialogVisible: false,
            dialogTitle: "",
            loading: false,
        };
    },
    computed: {
        selection() {
            return (this.value || []).map((v) => v.id);
        },
    },
    methods: {
        index() {
            this.loading = true;
            let params = {
                mode: "table",
                page: this.pagenate.current_page || 1,
                per_page: this.pagenate.per_page || 10,
            };
            axios
                .get(`${this.name}`, { params })
                .then((response) => {
                    this.loading = false;
                    this.pagenate = response.data;
                })
                .then(() => {
                    for (let index in this.pagenate.data) {
                        if (
                            this.selection.includes(
                                this.pagenate.data[index].id
                            )
                        ) {
                            this.$refs.multipleTable.toggleRowSelection(
                                this.pagenate.data[index],
                                true
                            );
                        }
                    }
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
        destroy(item) {
            this.$confirm("是否確認刪除？", "確認訊息", {
                distinguishCancelAndClose: true,
                confirmButtonText: "刪除",
                cancelButtonText: "取消",
            }).then(() => {
                axios
                    .delete(`${this.name}/${item.id}`)
                    .then((response) => {
                        this.index();
                        this.$message.success("刪除成功");
                    })
                    .catch((error) => {
                        this.$message.error("刪除失敗");
                    });
            });
        },
        command(command) {
            command.callback(command.args);
        },
        select(selection, row) {
            this.$emit("update:value", selection);
        },
    },
};
</script>
