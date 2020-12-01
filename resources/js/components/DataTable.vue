<template>
    <div class="container">
        <div>
            <el-card class="box-card">
                <div slot="header" class="d-flex justify-content-between" v-if="target.id">
                    <div>
                        {{ target.id }}. {{ target.label }}
                    </div>
                    <div>
                        <el-button type="text" icon="el-icon-close" @click="target={}"></el-button>
                    </div>
                </div>
                <div>
                    <el-tag
                        v-for="attachment of target[attachment_name]"
                        :key="attachment.id"
                        closable
                        @close="detach(attachment)"
                        >{{ attachment.id }}. {{ attachment.label }}
                    </el-tag>
                </div>
            </el-card>
        </div>

        <el-tabs v-model="current_tab" @tab-click="index">
            <el-tab-pane
                v-for="tab of actived_tabs"
                :key="tab.url"
                :label="tab.label"
                :name="tab.name"
            >
                <el-button @click="create">新增</el-button>
                <el-button @click="index">重新整理</el-button>
                <item-list
                    :data="pagenates[tab.name].data"
                    :selection.sync="selection"
                    @push="push"
                    @edit="edit"
                    @destroy="destroy"
                ></item-list>
                <el-pagination
                    layout="slot, sizes, prev, pager, next, jumper, ->, total"
                    :current-page.sync="pagenates[tab.name].current_page"
                    :page-size.sync="pagenates[tab.name].per_page"
                    :total="pagenates[tab.name].total"
                    @current-change="index"
                    @size-change="index"
                    class="text-center"
                >
                </el-pagination>
            </el-tab-pane>
        </el-tabs>
        <el-dialog :title="dialogTitle" :visible.sync="dialogVisible">
            <update-or-create-item
                :model="editableItem"
                @submit="updateOrStore"
            ></update-or-create-item>
        </el-dialog>
    </div>
</template>

<script>
export default {
    created() {
        this.current_tab = this.tabs[0].name;
        Object.entries(this.tabs).forEach((item) => {
            this.$set(this.pagenates, item[1].name, {});
        });
        this.index();
    },
    data() {
        return {
            current_tab: "",
            tabs: [
                { name: "group", label: "題組" },
                { name: "question", label: "題目" },
                { name: "option", label: "題項" },
            ],
            editableItem: {},
            pagenates: {},
            dialogTitle: "",
            dialogVisible: false,
            selection: [],
            target: {},
            target_tab: "",
        };
    },
    computed: {
        attachment_name() {
            return `attachments_of_${this.current_tab}`;
        },
        attachment_names() {
            return Object.keys(this.target).filter(
                (item) => item.indexOf("attachments_of_") == 0
            );
        },
        actived_tabs() {
            if (this.target.hasOwnProperty("id")) {
                let tabs = this.tabs.filter(
                    (item) =>
                        this.attachment_names.includes(
                            `attachments_of_${item.name}`
                        ) || item.name == this.target_tab
                );
                return tabs;
            }
            return this.tabs;
        },
    },
    methods: {
        updateOrStore(item) {
            if (item.hasOwnProperty("id")) {
                this.update(item);
            } else {
                this.store(item);
            }
        },
        index() {
            let params = {
                page: this.pagenates[this.current_tab].current_page || 1,
                per_page: this.pagenates[this.current_tab].per_page || 10,
            };
            axios
                .get(`${this.current_tab}`, { params })
                .then((response) => {
                    this.pagenates[this.current_tab] = response.data;
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
        store(item) {
            axios
                .post(`${this.current_tab}`, item)
                .then((response) => {
                    this.index();
                    this.$message.success("儲存成功");
                })
                .catch((error) => {
                    this.$message.error("儲存失敗");
                });
        },
        show(item) {
            axios
                .get(`${this.current_tab}/${item.id}`)
                .then((response) => {
                    console.log(response.data);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        edit(item) {
            this.dialogVisible = true;
            this.dialogTitle = "編輯資料";
            this.editableItem = item;
        },
        update(item) {
            axios
                .put(`${this.current_tab}/${item.id}`, item)
                .then((response) => {
                    Object.assign(this.editableItem, response.data);
                    this.$message.success("更新成功");
                })
                .catch((error) => {
                    this.$message.error("更新失敗");
                });
        },
        destroy(item) {
            axios
                .delete(`${this.current_tab}/${item.id}`)
                .then((response) => {
                    this.pagenates[this.current_tab].data = this.pagenates[
                        this.current_tab
                    ].data.filter((v) => v !== item);
                    this.$message.success("刪除成功");
                })
                .catch((error) => {
                    this.$message.error("刪除失敗");
                });
        },
        push(item) {
            if (this.target.hasOwnProperty("id")) {
                if (
                    this.target[this.attachment_name] &&
                    this.target[this.attachment_name].every(v=>v.id != item.id)
                ) {
                    this.attach(item);
                }
            } else {
                this.target = item;
                this.target_tab = this.current_tab;
            }
        },
        attach(item) {
            axios
                .post(`${this.target_tab}/${this.target.id}/attach`, {
                    target: this.attachment_name,
                    id: item.id,
                })
                .then((response) => {
                    if(response.data.success){
                        this.target[this.attachment_name].push(item);
                        this.$message.success("連結成功");
                    }else{
                        this.$message.error("連結失敗");
                    }
                })
                .catch((error) => {
                    //this.$message.error("刪除失敗");
                });
        },
        detach(item) {
            axios
                .post(`${this.target_tab}/${this.target.id}/detach`, {
                    target: this.attachment_name,
                    id: item.id,
                })
                .then((response) => {
                    if(response.data.success){
                        this.target[this.attachment_name] = this.target[this.attachment_name].filter(v=>v.id != item.id);
                        this.$message.success("分離成功");
                    }else{
                        this.$message.error("分離失敗");
                    }
                })
                .catch((error) => {
                    //this.$message.error("刪除失敗");
                });
        },
    },
};
</script>
