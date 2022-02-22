<template>
    <form @keyup.enter="login()">
        <b-card style="margin-top: -50px">
            <div scope="header">
                ATOMS Log-In
            </div>
            <div>
                <b-form-input type="text"
                          placeholder="Email..."
                          autofocus
                          v-model="email" />
                <br>
                <b-form-input class="no-border"
                          type="password"
                          placeholder="Password..."
                          v-model="password" />

                <b-button variant="primary" pill block @click="login()">
                    Log In
                </b-button>
            </div>
        </b-card>
    </form>
</template>

<script>
    import { mapGetters } from "vuex";

    /**
     * Login panel
     */
    export default {
        name: 'login-card',
        props: {},
        data() {
            return {
                email: '',
                password: '',
            }
        },
        computed: {
            ...mapGetters({
                facility: 'facility/facility',
            }),
        },
        methods: {
            login() {
                let data = {
                    email: this.email,
                    password: this.password,
                };
                this.$store.dispatch("auth/login", data)
                    .then(r => {
                        let { user, member } = r;

                        // User logged in, redirect to their facility
                        if (user.id) {
                            // Get the area slug, if possible
                            let slug = this.$store.getters['area/slug'](member.area_id);
                            if (slug) {
                                this.$router.push({ name: 'Area Home', params: { facility: member.facility_id, area: slug }});
                            } else {
                                // Log in to current facility if set, otherwise users default
                                let facility_id = this.facility.id ? this.facility.id : member.facility_id;
                                this.$router.push({ name: 'Facility Home', params: { facility: facility_id }});
                            }
                        }
                    }).catch((e) => {
                        this.$store.commit('alerts/newMessage', { type: 'error', message: e.data }, {root: true});
                    });
            },
        },
        watch: {}
    }
</script>
