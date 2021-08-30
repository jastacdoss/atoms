<template>
    <div>
      hi
        <div v-for="facility in facilities" :key="facility.id">
            {{ facility.name }}
        </div>
    </div>
</template>

<script>
import RepositoryFactory from '../repositories/RepositoryFactory';
const FacilityRepository = RepositoryFactory.get('facility');

export default {
    name: 'Facility',
    components: {},
    data() {
        return {
            facilities: [],
        }
    },
    methods: {},
    computed: {},
    created() {
        this.facilities = FacilityRepository.get()
    }
}
</script>

<style scoped>

</style>
