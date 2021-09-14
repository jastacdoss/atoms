<template>
    <div class="px-5">
        <div class="row mb-3">
            <div class="col">
                <h5>Facilities</h5>
                {{ filtered.length }} / {{ facilities.length }}
            </div>
            <div class="col">
                <h5>Areas</h5>
                {{ areas.filtered }} / {{ areas.total }}
            </div>
            <div class="col">
                <h5>Cost</h5>
                {{ cost.filtered | toCurrency }} / {{ cost.total | toCurrency }}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-3">
                <h6>Filter Release</h6>
                <b-form-select v-model="filter.release" :options="releases" />
            </div>
            <div class="col-3">
                <h6>Filter TEam</h6>
                <b-form-select v-model="filter.team" :options="teams" />
            </div>
        </div>

        <table class="mx-auto table results">
            <thead>
            <tr class="">
                <td class="col-1">ID</td>
                <td class="col-3">Name</td>
                <td class="col-1">Areas <small>(O / T)</small></td>
                <td class="col-1">Release</td>
                <td class="col-1">Team</td>
                <td class="col-2">Start Train</td>
                <td class="col-1">Train Fac.</td>
                <td class="col-1">Go Live</td>
                <td class="col-1">Cost</td>
            </tr>
            </thead>
            <tbody>
            <template v-for="facility in filtered">
                <tr :key="'row-' + facility.id">
                    <td class="font-weight-bold">{{ facility.facility_id | uppercase }}</td>
                    <td>{{ facility.facility_name }}</td>
                    <td>{{ facility.areas }} <small>({{facility.areas_operational + ' / ' + facility.areas_tmu }})</small></td>
                    <td>{{ facility.release_adjusted }} <small>({{facility.release }})</small></td>
                    <td>{{ facility.team_id }}</td>
                    <td>{{ facility.training_date | moment('MM-DD-YYYY') }}</td>
                    <td>
                        <facility-dropdown v-model="facility.training_facility" :options="facilityIds" @change="update(facility, 'training_facility', $event)" />
                    </td>
                    <td>{{ facility.go_live_date | moment('MM-DD-YYYY') }}</td>
                    <td @click="toggle(facility.id)" class="cursor-pointer">{{ facility.cost | toCurrency }}</td>
                </tr>
                <tr :key="'details-' + facility.id" v-if="expand.includes(facility.id)">
                    <td colspan="9">
                        <travel :facility="facility" />
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
</template>

<script>
import Travel from "@/views/Travel";
import FacilityDropdown from "@/components/FacilityDropdown";
import RepositoryFactory from '../repositories/RepositoryFactory';
const FacilityRepository = RepositoryFactory.get('facility');

export default {
    name: 'Facility',
    components: {FacilityDropdown, Travel},
    data() {
        return {
            facilities: [],
            releases: [
                { value: null, text: 'All Releases' },
                { value: 1, text: 'Release 1' },
                { value: 2, text: 'Release 2' },
                { value: 3, text: 'Release 3' },
                { value: 4, text: 'Release 4' },
            ],
            teams: [
                { value: null, text: 'All Teams' },
                { value: 1, text: 'Team 1' },
                { value: 2, text: 'Team 2' },
                { value: 3, text: 'Team 3' },
                { value: 4, text: 'Team 4' },
                { value: 5, text: 'Team 5' },
            ],
            filter: {
                release: null,
                team: null,
            },
            expand: [],
        }
    },
    methods: {
        toggle(id) {
            // Find index
            let i = _.indexOf(this.expand, id);

            if (i === -1)
                this.expand.push(id);
            else
                this.expand.splice(i, 1);
        },
        update(facility, field, value) {
            console.log(field);
            console.log(value);
            // Update the facility field
            facility[field] = value;

            FacilityRepository.update(facility.id, facility)
                .then(r => {
                    // Find the facility and update the record
                    let idx = _.findIndex(this.facilities, { id: r.data.id });
                    this.$set(this.facilities, idx, r.data);
                });
        },
    },
    computed: {
        cost() {
            return {
                total: _.sumBy(this.facilities, f => _.sumBy(f.travellers, 'cost')),
                filtered: _.sumBy(this.filtered, f => _.sumBy(f.travellers, 'cost')),
            }
        },
        areas() {
            return {
                total: _.sumBy(this.facilities, 'areas'),
                filtered: _.sumBy(this.filtered, 'areas'),
            }
        },
        facilityIds() {
            return _.map(this.facilities, f => { return { value: f.facility_id, text: f.facility_id.toUpperCase() } });
        },
        filtered() {
            return _.filter(this.facilities, f => {
               return (!this.filter.release || f.release_adjusted === this.filter.release) &&
                   (!this.filter.team || f.team_id === this.filter.team)
            });
        }
    },
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
