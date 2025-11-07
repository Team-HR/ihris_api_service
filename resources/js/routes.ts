// type CoreFunctionLevel1 = "mfoPeriod" | "department" | "parent" | "children";
// type CoreFunctionLevel2 =
//     | CoreFunctionLevel1
//     | `parent.${CoreFunctionLevel1}`
//     | `children.${CoreFunctionLevel1}`;

// type CoreFunctionRelations = CoreFunctionLevel2;

// type MfoRelation = "coreFunctions" | `coreFunctions.${CoreFunctionRelations}`;

// const mfos = {
//     all: "/api/ihris_v2/mfos",

//     show: (
//         mfoPeriodId: number | string,
//         departmentId: number | string,
//         withRelations?: MfoRelation[]
//     ) => {
//         if (!withRelations || withRelations.length === 0)
//             return `/api/ihris_v2/mfos/${mfoPeriodId}`;

//         const params = withRelations
//             .map((rel) => `with[]=${encodeURIComponent(rel)}`)
//             .join("&");

//         return `/api/ihris_v2/mfos/${mfoPeriodId}?${params}/departments/${departmentId}`;
//     },
// };

const coreFunction = {
    show: (mfoPeriodId: string | number, departmentId: string | number) =>
        `/api/ihris_v2/mfo-periods/${mfoPeriodId}/departments/${departmentId}`,
};

const successIndicators = {
    show: (userId: string | number) =>
        `/api/ihris_v2/users/${userId}/success-indicators`,
};

export const routes = { coreFunction, successIndicators };
