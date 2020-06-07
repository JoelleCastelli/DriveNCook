package javafx;

import javafx.beans.property.SimpleStringProperty;
import javafx.beans.property.StringProperty;

public class FidelityStep {
    private final StringProperty id;
    private final StringProperty step;
    private final StringProperty reduction;
    private final StringProperty user_id;

    public FidelityStep() {
        this(null, null, null, null);
    }

    public FidelityStep(String id, String step, String reduction, String user_id) {
        this.id = new SimpleStringProperty(id);
        this.step = new SimpleStringProperty(step);
        this.reduction = new SimpleStringProperty(reduction);
        this.user_id = new SimpleStringProperty(user_id);
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

    public String getUser_id() {
        return user_id.get();
    }

    public StringProperty user_idProperty() {
        return user_id;
    }

    public void setUser_id(String user_id) {
        this.user_id.set(user_id);
    }
}
