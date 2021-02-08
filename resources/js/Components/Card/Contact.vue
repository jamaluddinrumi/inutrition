<template>
    <v-card>
        <!-- <v-card-title> </v-card-title>
        <v-card-subtitle> </v-card-subtitle> -->
        <v-card-text>
            <v-list>
                <v-list-item>
                    <v-list-item-avatar>
                        <v-img
                            :src="
                                $page.props.storageUrl + '/' + user.profile_photo_path
                            "
                        ></v-img>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title
                            v-text="userName"
                        ></v-list-item-title>
                        <v-list-item-subtitle
                            v-text="user.email"
                        ></v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-card-text>
        <v-card-actions class="flex justify-center">
            <v-btn
                rounded
                color="primary"
                :href="'mailto:' + user.email"
                class="font-bold px-4 mb-6"
                ><v-icon small class="mr-2">fas fa-envelope</v-icon>Email</v-btn
            >
        </v-card-actions>
    </v-card>
</template>

<script>
export default {
    props: {
        user: {
            type: Object,
        },
    },
    computed: {
        userName: function () {
            return _.startCase(this.user.name);
        },
    },
};
</script>

<style>
</style>