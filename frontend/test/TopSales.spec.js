import {mount} from '@vue/test-utils';
import axios from 'axios';
import TopSales from '../src/components/TopSales.vue';
import {describe, it, expect, beforeEach, vi} from 'vitest';

vi.mock('axios');

vi.mock('vue-router', () => ({
    useRoute: vi.fn(() => ({
        query: { keyword: '' },
    })),
}));

async function createComponent(propsData = {}) {
    return mount(TopSales, {
        propsData,
    });
}
describe('Get top sales for Theater', () => {
    let wrapper;

    beforeEach(async () => {
        wrapper = await createComponent();
    });
    const spy = vi.spyOn(axios, 'get');


    it('Initial Page load', () => {
        expect(wrapper.html()).toContain('Find Top Sales for a Date');
    });

    it('displays an error if no date is entered', async () => {

        expect(wrapper.find('.text-red-500').exists()).toBeFalsy();
        expect(wrapper.find('.bg-gray-100').exists()).toBeFalsy();

        await wrapper.find('input[type="date"]').setValue('');
        await wrapper.vm.fetchTopSales();

        expect(wrapper.find('.text-red-500').exists())
        expect(wrapper.find('.text-red-500').text()).toContain('Please enter a valid date.');
    });

    it('calls the API and displays sales data on valid date entry', async () => {
        const date = '2024-11-09';
        const data = [
            {id: 1, theater: 'Theater 1', total_sales: 1500},
            {id: 2, theater: 'Theater 2', total_sales: 1000},
        ];

        axios.get.mockResolvedValueOnce({
            data: {success: true, data: data},
        });

        await wrapper.setData({date: date});
        await wrapper.vm.fetchTopSales();

        expect(spy).toHaveBeenCalledWith(
            `${import.meta.env.VITE_API_BASE_URL}/sale?date=${date}`
        );

        const salesText = wrapper.findAll('.bg-gray-100 p span');
        expect(salesText[0].html()).toContain('Theater 1');
        expect(salesText[1].html()).toContain('1500');
        expect(salesText[2].html()).toContain('Theater 2');
        expect(salesText[3].html()).toContain('1000');
    });

    it('displays an error message if API returns no data', async () => {
        const date = '2024-11-09';

        axios.get.mockResolvedValueOnce({
            data: {success: false, message: 'No data found for this date.'},
        });

        await wrapper.setData({date: date});
        await wrapper.vm.fetchTopSales();

        expect(spy).toHaveBeenCalledWith(
            `${import.meta.env.VITE_API_BASE_URL}/sale?date=${date}`
        );
        expect(wrapper.find('.text-red-500').text()).toBe('No data found for this date.');
    });

    it('displays a default error message on API failure', async () => {
        axios.get.mockRejectedValueOnce(new Error('API Error'));

        await wrapper.setData({date: '2024-05-09'});
        await wrapper.vm.fetchTopSales();

        expect(wrapper.find('.text-red-500').text()).toBe('No data available for this date.');
    });

    it('does not call the API when an invalid date is provided', async () => {
        const invalidDate = '';

        const spy = vi.spyOn(axios, 'get').mockResolvedValue({
            data: {success: false, data: []},
        });

        await wrapper.setData({date: invalidDate});
        await wrapper.vm.fetchTopSales();

        expect(spy).not.toHaveBeenCalledWith(
            `${import.meta.env.VITE_API_BASE_URL}/sale?date=${invalidDate}`
        );
    });
});
