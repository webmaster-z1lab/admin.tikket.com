import * as types from '../../mutation-types'

export default {
    [types.SET_ORDER] (state, payload) {
        state.order = payload
    },
    [types.SET_ITEMS] (state, payload) {
        state.items = payload
    }
}
