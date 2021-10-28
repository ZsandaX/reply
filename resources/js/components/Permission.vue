<template>
    <div>
        <Table name="permissions" :value="value">
            <template v-slot:control>
                <el-button @click="fastCreate"> 快速新增 </el-button>
            </template>
        </Table>
        <el-dialog
            v-if="dialogVisible"
            :title="dialogTitle"
            :visible.sync="dialogVisible"
            :close-on-click-modal="false"
            append-to-body
            @close="reset"
        >
            <el-form>
                <el-form-item>
                    <el-input v-model="resource">
                        <template v-slot:prepend>資源</template>
                        <template v-slot:append>
                            <el-button type="primary" @click="prepend">
                                確認
                            </el-button>
                        </template>
                    </el-input>
                </el-form-item>
            </el-form>
            <Form
                :model="item"
                v-for="item of forms"
                :key="item.name"
                name="permissions"
                :inline="true"
                disabled
            />
        </el-dialog>
    </div>
</template>

<script>
export default {
    props: {
        value: Array,
    },
    data() {
        return {
            resource: "",
            actions: ["index", "create", "store", "edit", "update", "destroy"],
            forms: [],
            dialogTitle: "快速新增",
            dialogVisible: false,
        };
    },
    methods: {
        fastCreate() {
            this.dialogVisible = true;
        },
        prepend() {
            this.forms = [
                { name: this.resource, guard_name: "web" },
                ...this.actions.map((action) => ({
                    name: `${this.resource}.${action}`,
                    guard_name: "api",
                })),
            ];
        },
        reset() {
            this.resource = "";
            this.forms = [];
        },
        filterTag(){

        }
    },
};
</script>
