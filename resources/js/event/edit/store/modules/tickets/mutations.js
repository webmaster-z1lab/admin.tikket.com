import * as types from '../../mutation-types'

export default {
    [types.SET_TICKETS] (state, payload) {
        state.ticket = payload
    }
}
