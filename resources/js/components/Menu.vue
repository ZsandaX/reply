<template>
    <div>
        <Tree name="menus" :value="value" v-if="mode == 'tree'">
            <template v-slot:control>
                <el-radio-group class="float-right" v-model="mode">
                    <el-radio-button label="tree"></el-radio-button>
                    <el-radio-button label="table"></el-radio-button>
                </el-radio-group>
            </template>
        </Tree>
        <Table name="menus" :value="value" v-if="mode == 'table'">
            <template v-slot:control>
                <el-radio-group class="float-right" v-model="mode">
                    <el-radio-button label="tree"></el-radio-button>
                    <el-radio-button label="table"></el-radio-button>
                </el-radio-group>
            </template>
        </Table>
    </div>
</template>

<script>
export default {
    props: {
        value: Array,
    },
    data() {
        return {
            mode: "tree",
        };
    },
    methods: {},
};
</script>
