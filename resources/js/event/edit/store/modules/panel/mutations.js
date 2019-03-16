import * as types from '../../mutation-types'

export default {
    [types.SET_ACCESSES] (state, payload) {
        state.accesses = payload
    }
}
