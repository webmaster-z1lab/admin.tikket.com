export default {
    /* Create Activity */
    'CHANGE_ACTIVITY_FORM' (state, payload) {
        state.activity_form = payload.data
        state.activity_form.key = payload.key
    },

    /* Group */
    'CHANGE_GROUP_FORM' (state, payload) {
        state.group_form = payload.data
        state.group_form.key = payload.key
    }
}