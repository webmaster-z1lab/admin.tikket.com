export default {
    /* Create Activity */
    changeActivityForm(context, payload) {
        context.commit('CHANGE_ACTIVITY_FORM', payload)
    },

    /* Group */
    changeGroupForm(context, payload) {
        context.commit('CHANGE_GROUP_FORM', payload)
    }
}