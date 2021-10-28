<template>
    <div v-loading="loading">
        <el-button v-if="$route.meta.create && $route.path == `/${name}`" type="primary" icon="el-icon-circle-plus" @click="create">
            新增
        </el-button>
        <slot name="control"> </slot>
        <el-table
            ref="multipleTable"
            :data="pagenate.data"
            @select="select"
            @select-all="select"
            style="width: 100%"
            @filter-change="filterChange"
            @sort-change="sortChange"
            row-key="id"
            default-expand-all
            :tree-props="{children: 'children', hasChildren: 'hasChildren'}">
        >
            <el-table-column prop="selection" type="selection" width="55"></el-table-column>
            <el-table-column prop="id" label="序號" sortable="custom">
                <template v-slot="{row}"><span v-selected="row">{{row.id}}</span></template>
            </el-table-column>
            <el-table-column
                :prop="prop"
                :label="column"
                v-for="(column, prop) of pagenate.columns"
                :filters="pagenate.filters[prop]"
                :key="prop"
                :column-key="prop"
                :sortable="pagenate.sorts[prop]"
            ></el-table-column>
            <slot name="appendColumn"> </slot>
            <el-table-column label="操作" v-if="$route.path == `/${name}`">
                <template v-slot:header>
                    <div class="d-flex">
                        <el-input
                            v-model="keyword"
                            size="mini"
                            placeholder="輸入關鍵字搜尋"
                        />
                        <el-button size="mini" @click="index">搜尋</el-button>
                    </div>
                </template>
                <template v-slot="{ row }">
                    <el-dropdown trigger="click" @command="command">
                        <span class="el-dropdown-link">
                            <i class="el-icon-more text-secondary"></i>
                        </span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item
                                v-if="$route.meta.edit"
                                icon="el-icon-edit-outline"
                                :command="{ args: row, callback: edit }"
                            >
                                編輯
                            </el-dropdown-item>
                            <el-dropdown-item
                                v-if="$route.meta.destroy"
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
        name: {
           type: String,
           default: function(){
               return this.$route.path.substr(1)
           },
        },
        value: Array,
    },
    created() {
        this.index();
        console.log(this.$route);
    },
    data() {
        return {
            editableItem: {},
            pagenate: {},
            dialogVisible: false,
            dialogTitle: "",
            loading: false,
            keyword: "",
            filters: [],
            sorts: []
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
                keyword: this.keyword,
                filters: this.filters,
                sorts: this.sorts
            };
            axios
                .get(`${this.name}`, { params })
                .then((response) => {
                    this.loading = false;
                    this.pagenate = response.data;
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
        filterChange(filters){
            this.filters = filters;
            this.index();
        },
        sortChange(sorts){
            if(sorts.order){
                this.sorts = [sorts.prop, sorts.order.replace("ending", "")];
            }else{
                this.sorts = null;
            }
            this.index();
        },
    },
    directives: {
        selected:{
            bind(el, binding, vnode) {
                if (vnode.context.selection.includes(binding.value.id))
                {
                    vnode.context.$refs.multipleTable.toggleRowSelection(binding.value, true);
                }

            }
        }
    }
};
</script>
