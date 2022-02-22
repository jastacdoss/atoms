<template>
    <div>
        <table class="results table">
            <thead>
            <tr>
                <td class="col">ID</td>
                <td class="col"></td>
            </tr>
            </thead>
        </table>
    </div>
</template>

<script>
import RepositoryFactory from '../repositories/RepositoryFactory';
const FacilityRepository = RepositoryFactory.get('facility');

export default {
    name: "Siblings",
    components: {},
    props: {
        facilityId: Number,
    },
    data() {
        return {
            siblings: [],
        }
    },
    methods: {
        fetch() {
            FacilityRepository.siblings(this.facilityId)
                .then(r => {
                    this.siblings = r.data;
                });
        }
    },
    computed: {},
    created() {
    },
}
</script>

<style scoped>

</style>
