<template>
    <div>
        <b-form-select v-model="facility_id" :options="options" @change="$emit('change', $event)" />
    </div>
</template>

<script>
export default {
    name: "FacilityDropdown",
    components: {},
    props: {
        options: Array,
        value: String,
    },
    data() {
        return {
            facility_id: this.value,
        }
    },
    methods: {},
    computed: {},
    created() {
    },
    watch: {
        facility_id(n) {
            this.$emit('input', n)
        }
    }
}
</script>

<style scoped>

</style>
