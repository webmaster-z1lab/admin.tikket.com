import * as types from '../../mutation-types'

export default {
    setOrder(context, payload) {
        context.commit(types.SET_ORDER, payload)
    },
    setItems(context, payload) {
        context.commit(types.SET_ITEMS, payload)
    }
}
