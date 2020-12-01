<template>
    <div>
        <Table name="roles" :value="value"></Table>
    </div>
</template>

<script>
export default {
    props: {
        value: {
            type: Array,
        },
    },
    data() {
        return {
        };
    },
    methods: {

    },
};
</script>
