<template>
    <el-table :data="data" ref="multipleTable" @selection-change="handleSelectionChange" style="width: 100%">
        <el-table-column type="selection" width="55"></el-table-column>
        <el-table-column prop="id" label="序號" width="55"></el-table-column>
        <el-table-column
            prop="label"
            label="顯示名稱"
            width="180"
        ></el-table-column>
        <el-table-column
            prop="value"
            label="儲存值"
            width="180"
        ></el-table-column>
        <el-table-column
            prop="created_at"
            label="建立時間"
            width="180"
        ></el-table-column>
        <el-table-column
            prop="updated_at"
            label="更新時間"
            width="180"
        ></el-table-column>
        <el-table-column>
            <template slot-scope="scope">
                <el-button type="text" @click="edit(scope.row)">
                    編輯
                </el-button>
                <el-button type="text" @click="destroy(scope.row)">
                    刪除
                </el-button>
            </template>
        </el-table-column>
        <el-table-column width="55">
            <template slot-scope="scope">
                <div>
                    <el-button @click="push(scope.row)" icon="el-icon-sell" circle></el-button>
                </div>
            </template>
        </el-table-column>
    </el-table>
</template>

<script>
export default {
    props: {
        data: {
            type: Array,
            default: function() {
                return [];
            }
        },
        selection: {
            type: Array,
            default: function() {
                return [];
            }
        },
    },
    methods: {
        push(item) {
            this.$emit("push", item);
        },
        edit(item) {
            this.$emit("edit", item);
        },
        destroy(item) {
            this.$emit("destroy", item);
        },
        handleSelectionChange(items){
            this.$emit("update:selection", items);
        }
    }
};
</script>
