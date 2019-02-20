import * as types from './mutation-types'

export default {
    initEvent(context, payload) {
        context.commit(types.INIT_EVENT, JSON.parse(payload))
    }
}
