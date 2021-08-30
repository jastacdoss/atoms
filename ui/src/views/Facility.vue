<template>
    <div class="px-5">
        <table class="mx-auto table results">
            <thead>
            <tr class="">
                <td class="col-1">ID</td>
                <td class="col-3">Name</td>
                <td class="col-1">Areas</td>
                <td class="col-1">Release</td>
                <td class="col-1">Team</td>
                <td class="col-2">Start Train</td>
                <td class="col-2">Train Fac.</td>
                <td class="col-2">Go Live</td>
            </tr>
            </thead>
            <tbody>
            <tr v-for="facility in facilities" :key="facility.id">
                <td class="font-weight-bold">{{ facility.facility_id | uppercase }}</td>
                <td>{{ facility.facility_name }}</td>
                <td>{{ facility.areas_operational + '/' + facility.areas_tmu }}</td>
                <td>{{ facility.release_adjusted }} <small>({{facility.release }})</small></td>
                <td>{{ facility.team_id }}</td>
                <td>{{ facility.training_date }}</td>
                <td>{{ facility.training_facility | uppercase }}</td>
                <td>{{ facility.go_live_date }}</td>
            </tr>
            </tbody>
        </table>
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
        FacilityRepository.get()
        .then(r => {
            this.facilities = r.data;
        })
    }
}
</script>

<style scoped>

</style>
