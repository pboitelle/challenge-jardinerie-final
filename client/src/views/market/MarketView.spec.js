import {mount} from '@vue/test-utils'
import { describe, it, expect } from 'vitest';
import MarketView from './MarketView.vue'

describe('MarketView', () => {
    it('renders correctly', () => {
        const wrapper = mount(MarketView)
        expect(wrapper.isVueInstance()).toBe(true)
    })
})