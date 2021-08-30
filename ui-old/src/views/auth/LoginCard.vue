<template>
    <form @keyup.enter="login()">
        <card class="card-login card-plain" style="margin-top: -50px">
            <div>
<!--                < class="no-border"-->
<!--                          type="text"-->
<!--                          placeholder="Email..."-->
<!--                          addon-left-icon="fas fa-at"-->
<!--                          focus-->
<!--                          v-model="email">-->
<!--                </>-->
                <br>
                <fg-input class="no-border"
                          type="password"
                          placeholder="Password..."
                          addon-left-icon="fas fa-key"
                          v-model="password">
                </fg-input>
                <n-button type="primary" round block @click.native="login()">
                    Log In
                </n-button>
                <div class="pull-left">
                    <h6>
                        <router-link class="link footer-link" :to="{ name: 'Register' }">
                            Create Account
                        </router-link>
                    </h6>
                </div>
                <div class="pull-right">
                    <h6>
                        <router-link class="link footer-link" :to="{ name: 'Reset Password' }">
                            Reset Password
                        </router-link>
                    </h6>
                </div>
            </div>
        </card>
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
