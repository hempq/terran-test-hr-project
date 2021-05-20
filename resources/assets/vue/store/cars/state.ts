export default {
  users: [],
  cars: [],
  user: {},
  searchCache:{
    license_plate_number: '',
    brand: '',
    user: '',
  },
  userSearchName: '',
  pagination: {
    currentPage: 1,
    perPage: 5,
    totalCars: 0,
    totalPages: 0,
  },
  isLoading: false,
  isModalLoading: false,
  isModalVisible: false,
  
};
