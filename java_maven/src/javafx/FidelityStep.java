package javafx;

import javafx.beans.property.SimpleStringProperty;
import javafx.beans.property.StringProperty;

public class FidelityStep implements Comparable<FidelityStep> {
    private final StringProperty id;
    private final StringProperty step;
    private final StringProperty reduction;
    private final StringProperty userId;

    public FidelityStep() {
        this(null, null, null, null);
    }

    public FidelityStep(String id, String step, String reduction, String userId) {
        this.id = new SimpleStringProperty(id);
        this.step = new SimpleStringProperty(step);
        this.reduction = new SimpleStringProperty(reduction);
        this.userId = new SimpleStringProperty(userId);
    }

    public String getId() {
        return id.get();
    }

    public StringProperty idProperty() {
        return id;
    }

    public void setId(String id) {
        this.id.set(id);
    }

    public String getStep() {
        return step.get();
    }

    public StringProperty stepProperty() {
        return step;
    }

    public void setStep(String step) {
        this.step.set(step);
    }

    public String getReduction() {
        return reduction.get();
    }

    public StringProperty reductionProperty() {
        return reduction;
    }

    public void setReduction(String reduction) {
        this.reduction.set(reduction);
    }

    public String getUserId() {
        return userId.get();
    }

    public StringProperty userIdProperty() {
        return userId;
    }

    public void setUserId(String userId) {
        this.userId.set(userId);
    }

    @Override
    public int compareTo(FidelityStep fidelityStep) {
        return (Integer.compare(Integer.parseInt(this.getStep()), Integer.parseInt(fidelityStep.getStep())));
    }
}
