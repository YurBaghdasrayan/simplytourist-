<template>
    <FrameOutside @click="optionsVisible = false" @focus="handleOutsideFocus">
        <div class="FormSelect" :style="optionsVisible && `z-index: 99999`" @focus.capture="handleFocus">
            <fieldset
                class="form-control"
                :class="{ 'FormSelect__control--focus': optionsVisible }"
            >
                <div class="FormSelect__legend" @click="optionsVisible = !optionsVisible">
                    <div class="FormSelect__legend-inner">
                        <div class="FormSelect__legend-body">
              <span
                  class="FormSelect__placeholder"
                  :class="{ 'u-visually-hidden': valueString }"
              >{{ legend }}</span>
                            <span
                                v-if="valueString"
                                aria-hidden="true"
                                class="FormSelect__value"
                            >{{ labelString }}</span>
                        </div>
                        <SvgAngle
                            class="FormSelect__icon"
                            :class="{ 'FormSelect__icon--rotate-180': optionsVisible }"
                        />
                    </div>
                </div>
                <div class="FormSelect__options" :class="{ 'u-visually-hidden': !optionsVisible }">
                    <label v-for="option in options" :key="option.label || option" class="FormSelect__option">
                        <!-- Using a dynamic :type is not possible because of a IE11 bug. -->
                        <input
                            v-if="multiSelect"
                            v-model="localValue"
                            :value="option.value || option"
                            type="checkbox"
                            class="FormSelect__input"
                        >
                        <input
                            v-else
                            v-model="localValue"
                            :value="option.value || option"
                            type="radio"
                            class="FormSelect__input"
                        >
                        {{ option.label || option }}
                    </label>
                </div>
            </fieldset>
            <input type="hidden" :name="inputName" :value="valueString">

        </div>
    </FrameOutside>
</template>

<script>
import FrameOutside from "./FrameOutside";
import SvgAngle from "./SvgAngle.vue";

export default {
    name: "FormSelect",
    components: {
        FrameOutside,
        SvgAngle
    },
    model: {
        event: "change"
    },
    props: {
        legend: {
            type: String,
            default: "Select"
        },
        options: {
            type: Array,
            default: () => []
        },
        value: {
            type: [Array, String, Number],
            default: ""
        },
        inputName:{}
    },
    data() {
        return {
            optionsVisible: false
        };
    },
    computed: {
        valueString() {
            return this.multiSelect ? this.value.join(",") : this.value;
        },
        labelString(){
            let result=[];
            this.value.forEach(element => {
                this.options.forEach(option=>{
                    if(option.value===element)
                        result.push(option.label);
                })
            });
            return result.join(", ");
        },
        localValue: {
            get() {
                return this.value;
            },
            set(data) {
                this.$emit("change", data);
            }
        },
        multiSelect() {
            console.log(this.value)
            return Array.isArray(this.value);
        }
    },
    methods: {
        handleFocus(e) {
            // Fix IE11 quirks.
            if (e.target.tagName === "DIV") return;
            this.optionsVisible = true;
        },
        handleOutsideFocus(e) {
            console.log(e);
            this.optionsVisible = false;
        }
    }
};
</script>

<style lang="scss">
$placeholder-color: #979797;
$form-control-padding: 0.75em;

@mixin form-control {
    display: block;

    background-color: #fff;
    &:focus,
    &--focus {
    }
}


// 1. Limit the height and move options above the following elements.
// 2. Reset default legend styles.
.FormSelect {
    position: relative; // 1

    &__legend {
        width: 100%; // 2
        float: left; // 2
        cursor: pointer;
    }

    &__legend-inner {
        display: flex;
        justify-content: space-between;
        //padding: $form-control-padding;
    }

    &__legend-body {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    &__placeholder {
        color: $placeholder-color;
    }

    &__icon {
        transition: transform 0.2s;

        &--rotate-180 {
            transform: rotate(180deg);
        }
    }

    &__options {
        padding-right: $form-control-padding;
        padding-bottom: $form-control-padding;
        padding-left: $form-control-padding;
    }

    &__option {
        display: block;

        &:not(:first-child) {
            margin-top: 0.25em;
        }
    }

    &__input {
        margin-right: 0.125em;
    }
}
.FormSelect__control {
    border: none;
}
fieldset.form-control {
    padding-left: 0px;
    padding-right: 0px;
}
.FormSelect__options{
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    box-sizing: border-box;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    border-radius: 15px;
}
.FormSelect__control:focus, .FormSelect__control--focus{
    box-shadow:none !important;
}
.FormSelect__legend {
    border: 1px solid #E2E8F0;
    box-sizing: border-box;
    border-radius: 15px;
}
</style>
