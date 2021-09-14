<template>
    <div class="container">
        <div class="row">
            <div class="col">
                <h6>Who's Travelling</h6>
            </div>
            <div class="col">
                <h6>Method</h6>
            </div>
            <div class="col">
                <h6>Travel</h6>
            </div>
            <div class="col">
                <h6>Lodging</h6>
            </div>
            <div class="col">
                <h6>M & IE</h6>
            </div>
        </div>
        <div v-for="(traveller, idx) in facility.travellers" :key="facility.id + '-' + traveller.who">
            <div class="row mb-2 " :class="idx %2 === 0 ? '' : 'bg-lightgray'">
                <div class="col">
                    <span v-if="traveller.who === 'POCs'">{{ traveller.how_many }}x </span>
                    {{ traveller.who }}
                </div>
                <div class="col">
                    {{ traveller.travel.method || 'HOME' }}
                    <small v-if="traveller.travel.method">({{ traveller.from }} / {{ traveller.to }})</small>
                </div>
                <div class="col">
                    {{ traveller.travel.cost || 0  | toCurrency }}
                    <small v-if="traveller.travel.method === 'pov'">({{ Math.round(traveller.travel.distance) }} miles)</small>
                </div>
                <div class="col">
                    {{ traveller.lodging || 0 | toCurrency }}
                </div>
                <div class="col">
                    {{ traveller.meals || 0 | toCurrency }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Travel",
    components: {},
    props: {
        facility: Object,
    },
    data() {
        return {}
    },
    methods: {},
    computed: {},
    created() {
    },
}
</script>

<style scoped>

</style>
