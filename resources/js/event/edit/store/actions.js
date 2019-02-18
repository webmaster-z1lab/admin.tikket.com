export default {
    changeEvent(context, payload) {
        context.commit('CHANGE_EVENT', payload)
    },
    setTicket(context, payload) {
        context.commit('SET_TICKET', payload)
    }
}
