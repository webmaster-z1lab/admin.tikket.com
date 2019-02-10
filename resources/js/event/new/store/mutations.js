export default {
    'CHANGE_EVENT' (state, payload) {
        state.event = payload
        state.start_event = false
    },
    'SET_TICKET' (state, payload) {
        state.ticket = payload
    }
}
