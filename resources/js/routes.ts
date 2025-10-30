type CoreFunctionLevel1 = "mfoPeriod" | "department" | "parent" | "children";
type CoreFunctionLevel2 =
    | CoreFunctionLevel1
    | `parent.${CoreFunctionLevel1}`
    | `children.${CoreFunctionLevel1}`;

type CoreFunctionRelations = CoreFunctionLevel2;

type MfoRelation = "coreFunctions" | `coreFunctions.${CoreFunctionRelations}`;

const mfos = {
    all: "/ihris_v2/mfos",

    show: (mfoId: number | string, withRelations?: MfoRelation[]) => {
        if (!withRelations || withRelations.length === 0)
            return `/ihris_v2/mfos/${mfoId}`;

        const params = withRelations
            .map((rel) => `with[]=${encodeURIComponent(rel)}`)
            .join("&");

        return `/ihris_v2/mfos/${mfoId}?${params}`;
    },
};

export const routes = { mfos };
