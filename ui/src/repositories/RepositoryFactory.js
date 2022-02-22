import FacilityRepository from './facilityRepository';

const repositories = {
  facility: FacilityRepository,
};

export default {
  get(name) {
    return repositories[name];
  },
};
