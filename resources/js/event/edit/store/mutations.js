import * as types from './mutation-types'

export default {
    [types.INIT_EVENT] (state, payload) {
        state.event = payload
    }
}

